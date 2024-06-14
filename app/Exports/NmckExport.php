<?php

namespace App\Exports;

use App\Models\ExcelRow;
use App\Models\Offer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class NmckExport implements FromCollection, WithHeadings, WithMapping
{
    protected $fileId;
    protected $offerIds;
    protected $monthlyData;
    protected $periodicData;
    protected $openSource;

    public function __construct($fileId, $offerIds, $monthlyData, $periodicData, $openSource)
    {
        $this->fileId = $fileId;
        $this->offerIds = $offerIds;
        $this->monthlyData = $monthlyData;
        $this->periodicData = $periodicData;
        $this->openSource = $openSource;
    }

    public function collection()
    {
        $rows = ExcelRow::where('demand_file_id', $this->fileId)->get();
        $offers = Offer::whereIn('id', $this->offerIds)->get();

        $collection = new Collection();

        foreach ($rows as $row) {
            $averagePriceOpenSources = $this->calculateAveragePriceFromOpenSources($row);
            $averagePriceCommercialOffers = $this->calculateAveragePriceFromCommercialOffers($offers);
            $weightedAveragePrice = $this->calculateWeightedAveragePrice($averagePriceOpenSources, $averagePriceCommercialOffers);
            $referencePrice = $this->calculateReferencePrice($row);
            $minimumPrice = min($averagePriceOpenSources, $averagePriceCommercialOffers, $weightedAveragePrice, $referencePrice);
            $priceWithMarkup = $this->calculatePriceWithMarkup($minimumPrice);
            $totalCost = $this->calculateTotalCost($row, $priceWithMarkup);

            $collection->push([
                'object_name' => $row->item_name,
                'unit' => $row->unit,
                'release_form' => $row->release_form,
                'dosage' => $row->dosage,
                'is_in_vzn' => $row->is_in_vzn  ? 'Да' : 'Нет',
                'average_price_open_sources' => $averagePriceOpenSources,
                'average_price_commercial_offers' => $averagePriceCommercialOffers,
                'weighted_average_price' => $weightedAveragePrice,
                'reference_price' => $referencePrice,
                'minimum_price' => $minimumPrice,
                'price_with_markup' => $priceWithMarkup,
                'quantity' => $row->quantity,
                'total_cost' => $totalCost,
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
            'Наличие в Перечне ЖНВЛП',
            'Средняя цена из открытых источников',
            'Средняя цена из коммерческих предложений',
            'Средневзвешенная цена',
            'Предельная цена из госреестра',
            'Минимальная цена (пунктов 6, 7, 8, 9)',
            'Цена с оптовой надбавкой и НДС',
            'Количество',
            'НМЦК (количество ЛС * цена из пункта 12)',
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
            $row['weighted_average_price'],
            $row['reference_price'],
            $row['minimum_price'],
            $row['price_with_markup'],
            $row['quantity'],
            $row['total_cost'],
        ];
    }

    protected function calculateAveragePriceFromOpenSources($row)
    {
        // Логика для расчета средней цены из открытых источников
        return 100; // Примерное значение, нужно заменить на реальную логику
    }

    protected function calculateAveragePriceFromCommercialOffers($offers)
    {
        // Логика для расчета средней цены из коммерческих предложений
        return 150;

    }

    protected function calculateWeightedAveragePrice($averagePriceOpenSources, $averagePriceCommercialOffers)
    {
        // Логика для расчета средневзвешенной цены
        return ($averagePriceOpenSources + $averagePriceCommercialOffers) / 2; // Примерное значение, нужно заменить на реальную логику
    }

    protected function calculateReferencePrice($row)
    {
        // Логика для расчета референтной цены
        return 120; // Примерное значение, нужно заменить на реальную логику
    }

    protected function calculatePriceWithMarkup($minimumPrice)
    {
        // Логика для расчета цены с оптовой надбавкой и НДС
        $priceWithMarkup = $minimumPrice * 1.15 * 1.1; // Примерное значение, нужно заменить на реальную логику
        return $priceWithMarkup;
    }

    protected function calculateTotalCost($row, $priceWithMarkup)
    {
        // Логика для расчета общей стоимости
        return $row->quantity * $priceWithMarkup; // Примерное значение, нужно заменить на реальную логику
    }
}
