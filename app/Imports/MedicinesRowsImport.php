<?php

namespace App\Imports;


use App\Models\MedicineRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Symfony\Component\DomCrawler\Crawler;

class MedicinesRowsImport implements ToModel
{
    protected $offerId;

    public function __construct(int $offerId)
    {
        $this->offerId = $offerId;
    }

    public function model(array $row)
    {
        if ((int)$row[0] > 0 && isset($row[6]) && !empty($row['1'])) {
            $existingRow = MedicineRows::where('trade_name', $this->cleanString($row['3']))->first();
            return new MedicineRows([
                'offer_id' => $this->offerId,
                'mnn' => $this->cleanString($row['1']),
                'name' => $this->cleanString($row['2']),
                'trade_name' => $this->cleanString($row['3']),
                'quantity' => (int)$row['4'],
                'price' => (float)$row['5'],
                'total' => (float)$row['6']
            ]);
        }
    }

    protected function cleanString($value)
    {
        // Замена переносов строк на пробелы
        return str_replace(["\r", "\n"], ' ', $value);
    }
}
