<?php

namespace App\Exports;

use App\Models\ExcelRow;
use App\Models\Offer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NmckExport implements FromCollection, WithCustomStartCell, WithStyles, WithEvents
{
    protected $fileId;
    protected $offerIds;

    public function __construct($fileId, $offerIds)
    {
        $this->fileId = $fileId;
        $this->offerIds = $offerIds;
    }

    public function collection()
    {
        // Получаем данные для файла и предложений
        $rows = ExcelRow::where('demand_file_id', $this->fileId)->get();
        $offers = Offer::whereIn('id', $this->offerIds)->get();

        // Заголовки
        $headings = [
            'Наименование объекта закупки',
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

        // Формируем данные для экспорта
        $data = [];
        foreach ($headings as $heading) {
            $data[] = [$heading];
        }

        // Заполняем строки данными из ExcelRow
        foreach ($rows as $row) {
            $data[0][] = $row->item_name;
            $data[1][] = $row->unit;
            $data[2][] = $row->release_form;
            $data[3][] = $row->dosage;
            $data[4][] = $row->jnvlp ? 'Да' : 'Нет';
            $data[5][] = $row->average_price_open_sources;
            $data[6][] = $row->average_price_offers;
            $data[7][] = $row->weighted_average_price;
            $data[8][] = $row->max_price_registry;
            $data[9][] = min($row->average_price_open_sources, $row->average_price_offers, $row->weighted_average_price, $row->max_price_registry);
            $data[10][] = $row->price_with_markup_vat;
            $data[11][] = $row->quantity;
            $data[12][] = $row->nmck;
        }

        // Заполняем строки данными из Offers (если применимо)
        foreach ($offers as $offer) {
            $data[0][] = $offer->item_name;
            $data[1][] = $offer->unit;
            $data[2][] = $offer->release_form;
            $data[3][] = $offer->dosage;
            $data[4][] = $offer->jnvlp ? 'Да' : 'Нет';
            $data[5][] = $offer->average_price_open_sources;
            $data[6][] = $offer->average_price_offers;
            $data[7][] = $offer->weighted_average_price;
            $data[8][] = $offer->max_price_registry;
            $data[9][] = min($offer->average_price_open_sources, $offer->average_price_offers, $offer->weighted_average_price, $offer->max_price_registry);
            $data[10][] = $offer->price_with_markup_vat;
            $data[11][] = $offer->quantity;
            $data[12][] = $offer->nmck;
        }

        // Возвращаем коллекцию для экспорта
        return new Collection($data);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Автоширина для всех столбцов от A до ZZ
                $columns = range('A', 'Z');
                foreach ($columns as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }

                $prefix = '';
                foreach ($columns as $column1) {
                    foreach ($columns as $column2) {
                        $sheet->getColumnDimension($column1 . $column2)->setAutoSize(true);
                    }
                }
            },
        ];
    }

    public function startCell(): string
    {
        return 'A1';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'A1:A15' => [
                'font' => ['bold' => true],
            ],
        ];
    }

    public function sheets(): array
    {
        return [
            'NMCK' => $this,
        ];
    }
}
