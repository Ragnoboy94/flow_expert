<?php

namespace App\Exports;

use App\Models\ExcelRow;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ExcelRowExport implements FromCollection, WithHeadings, WithEvents
{
    protected $fileId;
    protected $categoryId;
    protected $categoryName;

    public function __construct($fileId, $categoryId, $categoryName)
    {
        $this->fileId = $fileId;
        $this->categoryId = $categoryId;
        $this->categoryName = $categoryName;
    }

    public function collection()
    {
        $query = ExcelRow::where('demand_file_id', $this->fileId);

        if ($this->categoryId !== null) {
            $query->where('drug_category_id', $this->categoryId);
        } else {
            $query->whereNull('drug_category_id');
        }

        return $query->get([
            'department',
            'item_name',
            'release_form',
            'unit',
            'quantity',
            'price',
            'sum'
        ]);
    }

    public function headings(): array
    {
        return [
            'Отделение',
            'Наименование',
            'Форма выпуска',
            'Ед. изм.',
            'Количество',
            'Цена',
            'Сумма'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->insertNewRowBefore(1, 1);
                $sheet->mergeCells('A1:G1');
                $sheet->setCellValue('A1', $this->categoryName);
                $sheet->getStyle('A1')->getFont()->setBold(true);
                $sheet->getStyle('A1')->getFont()->setSize(14);
            }
        ];
    }
}
