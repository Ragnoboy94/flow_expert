<?php

namespace App\Exports;

use App\Models\ExcelRow;
use App\Models\MedicineRows;
use App\Models\MonthlyData;
use App\Models\Offer;
use App\Models\OnlineDrugPrice;
use App\Models\PeriodicData;
use App\Models\XmlData;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Symfony\Component\DomCrawler\Crawler;


class NmckExport implements FromCollection, WithHeadings, WithMapping
{
    protected $fileId;
    protected $offerIds;
    protected $openSource;

    public function __construct($fileId, $offerIds, $openSource)
    {
        $this->fileId = $fileId;
        $this->offerIds = $offerIds;
        $this->openSource = $openSource;
    }

    public function collection()
    {
        $rows = ExcelRow::where('demand_file_id', $this->fileId)->get();

        $collection = new Collection();

        foreach ($rows as $row) {
            $averagePriceOpenSources = $this->calculateAveragePriceFromOpenSources($row);
            $averagePriceCommercialOffers = $this->calculateAveragePriceFromCommercialOffers($row->item_name);
            $average_price_both_sources = $this->calculateWeightedAveragePrice($averagePriceOpenSources, $averagePriceCommercialOffers);
            $referencePrice = $this->calculateReferencePrice($row);
            $weightedAveragePrice = $this->calculateWeightedAveragePriceFromPeriodicData($row->id);
            $referencePriceNew = $this->calculateReferencePriceFromMonthlyData($row->id);
            $prices = array_filter([
                $average_price_both_sources,
                $referencePrice,
                $weightedAveragePrice,
                $referencePriceNew
            ], function($value) {
                return $value !== 0;
            });

            $minimumPrice = empty($prices) ? 0 : min($prices);
            $priceWithMarkup = $this->calculatePriceWithMarkup($minimumPrice);
            $totalCost = $this->calculateTotalCost($row, $priceWithMarkup);

            $collection->push([
                'object_name' => $row->item_name,
                'unit' => $row->unit,
                'release_form' => $row->release_form,
                'dosage' => $this->extractDosage($row->item_name),
                'is_in_vzn' => $row->is_in_vzn ? 'Да' : 'Нет',
                'average_price_open_sources' => $averagePriceOpenSources != 0 ? $averagePriceOpenSources : "Нет",
                'average_price_commercial_offers' => $averagePriceCommercialOffers != 0 ? $averagePriceCommercialOffers : "Нет",
                'average_price_both_sources' => $average_price_both_sources != 0 ? $average_price_both_sources : "0",
                'reference_price' => $referencePrice != 0 ? $referencePrice : "0",
                'weighted_average_price' => $weightedAveragePrice != 0 ? $weightedAveragePrice : "0",
                'reference_price_new' => $referencePriceNew != 0 ? $referencePriceNew : "0",
                'minimum_price' => $minimumPrice != 0 ? $minimumPrice : "0",
                'price_with_markup' => $priceWithMarkup != 0 ? $priceWithMarkup : "0",
                'quantity' => $row->quantity,
                'total_cost' => $totalCost != 0 ? $totalCost : "0",
            ]);
        }

        return $collection;
    }

    public function headings(): array
    {
        return [
            'Наименование ЛС',
            'Единицы измерения',
            'Лекарственная форма',
            'Дозировка',
            'Наличие лекарственного препарата в Перечне ЖНВЛП',
            'Средняя цена из открытых источников',
            'Средняя цена из коммерческих предложений',
            'Средняя цена из открытых источников и коммерческих предложений',
            'Предельная цена из госреестра',
            'Средневзвешенная цена',
            'Референтная цена',
            'Минимальная цена',
            'Цена единицы препарата с оптовой надбавкой и НДС',
            'Количество',
            'НМЦК',
        ];
    }

    public function map($row): array
    {
        return [
            $row['object_name'],
            $row['unit'],
            $row['release_form'],
            $row['dosage'],
            $row['is_in_vzn'],
            $row['average_price_open_sources'],
            $row['average_price_commercial_offers'],
            $row['average_price_both_sources'],
            $row['reference_price'],
            $row['weighted_average_price'],
            $row['reference_price_new'],
            $row['minimum_price'],
            $row['price_with_markup'],
            $row['quantity'],
            $row['total_cost'],
        ];
    }


    protected function calculateAveragePriceFromCommercialOffers($itemName)
    {
        $prices = MedicineRows::whereIn('offer_id', $this->offerIds)
            ->where('trade_name', 'LIKE', '%' . $itemName . '%')
            ->pluck('price')
            ->filter(function ($price) {
                return !is_null($price);
            });

        if ($prices->isEmpty()) {
            return 0;
        }

        return $prices->avg();
    }

    protected function calculateWeightedAveragePriceFromPeriodicData($excelRowId)
    {
        $data = PeriodicData::where('excel_row_id', $excelRowId)->get();

        $totalQuantity = $data->sum('quantity');
        $totalCost = $data->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        if ($totalQuantity == 0) {
            return 0;
        }

        return $totalCost / $totalQuantity;
    }

    protected function calculateReferencePriceFromMonthlyData($excelRowId)
    {
        $data = MonthlyData::where('excel_row_id', $excelRowId)->get();

        $totalVolume = $data->sum('quantity');
        $totalCost = $data->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        if ($totalVolume == 0) {
            return 0;
        }

        return $totalCost / $totalVolume;
    }

    protected function calculateWeightedAveragePrice($averagePriceOpenSources, $averagePriceCommercialOffers): float|int
    {
        return ($averagePriceOpenSources + $averagePriceCommercialOffers) / 2;
    }

    protected function calculateReferencePrice($row)
    {
        $prices = XmlData::where('id', $row->xml_data_id)->first();

        if (!isset($prices['price_value'])) {
            return 0;
        }

        return $prices->price_value;
    }

    protected function calculatePriceWithMarkup($minimumPrice)
    {
        return $minimumPrice * 1.15 * 1.1;
    }

    protected function calculateTotalCost($row, $priceWithMarkup)
    {
        return $row->quantity * $priceWithMarkup;
    }

    protected function extractDosage($itemName)
    {
        // Регулярное выражение для поиска дозировки
        if (preg_match('/(\d+(\.\d+)?)\s*(мг|г|мл)/i', $itemName, $matches)) {
            return $matches[0]; // Возвращаем найденную дозировку
        }
        return 'Не указано';
    }

    protected function calculateAveragePriceFromOpenSources($row)
    {
        if ($this->openSource) {
            $onlinePriceRecord = OnlineDrugPrice::where('drug_name', $row->item_name)
                ->where('updated_at', '>=', Carbon::now()->subDays(31))
                ->first();

            if ($onlinePriceRecord) {
                if ($onlinePriceRecord->online_price === null) {
                    return 0;
                }
                return $onlinePriceRecord->online_price;
            } else {
                return "Заглушка";
                $onlinePrice = $this->getMinPrice($this->cleanString($row['3']));
                OnlineDrugPrice::create([
                    'drug_name' => $row->item_name,
                    'online_price' => $onlinePrice,
                ]);
                return $onlinePrice;
            }
        }
        return 0;
    }

    protected function cleanString($value)
    {
        // Замена переносов строк на пробелы
        return str_replace(["\r", "\n"], ' ', $value);
    }

    private function getMinPrice(string $drugName): int|float
    {
        if (!$drugName) {
            return 0;
        }

        $prices = $this->parseGoogle($drugName);

        if (empty($prices)) {
            return 0;
        }

        return $this->calculateAveragePrice($prices);

    }

    private function fetchHtml($url)
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => $this->getRandomUserAgent()
            ])->get($url);
            return $response->body();
        } catch (\Exception $e) {
            // Обработка ошибок
            return '';
        }
    }

    private function getRandomUserAgent()
    {
        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3',
            'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:54.0) Gecko/20100101 Firefox/54.0',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.12; rv:53.0) Gecko/20100101 Firefox/53.0',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.82 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Safari/605.1.15',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0',
            'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; AS; rv:11.0) like Gecko',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:91.0) Gecko/20100101 Firefox/91.0'
        ];

        return $userAgents[array_rand($userAgents)];
    }

    private function parseGoogle($drugName)
    {
        $url = "https://www.google.com/search?q=" . urlencode($drugName . " цена");
        $html = $this->fetchHtml($url);
        if (empty($html)) return [];

        $crawler = new Crawler($html);

        return $crawler->filterXPath("//span[contains(text(), '₽')]")->each(function ($node) {
            $priceText = $node->text();
            $price = preg_replace('/[^0-9,]/', '', $priceText);
            $price = str_replace(',', '.', $price);
            return floatval($price);
        });
    }

    private function calculateAveragePrice($prices)
    {
        if (count($prices) === 0) return 0;
        return array_sum($prices) / count($prices);
    }
}
