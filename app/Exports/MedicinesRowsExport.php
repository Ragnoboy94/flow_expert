<?php

namespace App\Exports;

use App\Models\Offer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MedicinesRowsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $offer;

    public function __construct(Offer $offer)
    {
        $this->offer = $offer;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->offer->medicineRows;
    }

    public function headings(): array
    {
        return [
            ['Сформированное коммерческое предложение'],
            [
                'Международное не патентованное наименование',
                'Торговое наименование',
                'Форма выпуска',
                'Кол-во',
                'Цена (без ндс и оптовой надбавки)',
                'Цена (без ндс и оптовой надбавки)'
            ]
        ];
    }

    public function map($row): array
    {
        return [
            $row->mnn,
            $row->trade_name,
            $row->form,
            $row->quantity,
            $row->price,
            $row->total,
        ];
    }
}
