<?php

namespace App\Imports;

use App\Models\DrugCategory;
use App\Models\ExcelRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExcelRowsImport implements ToModel, WithHeadingRow
{
    protected $demandFileId;

    public function __construct($demandFileId)
    {
        $this->demandFileId = $demandFileId;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ((int)$row[0] > 0 && isset($row[10])) {
            $category_id = null;
            if (!empty($row[9])){
                $category = DrugCategory::firstOrCreate(['name' => $row[9]]);
                $category_id = $category->id;
            }
            $is_essential = mb_strtolower($row[10]) === 'присутствует';

            return new ExcelRow([
                'demand_file_id' => $this->demandFileId,
                'department' => $row[1],
                'item_name' => $row[2],
                'unit' => $row[3],
                'quantity' => $row[4],
                'price' => $row[5],
                'sum' => $row[6],
                'funding_source' => $row[7],
                'release_form' => $row[8],
                'drug_category_id' => $category_id,
                'is_essential' => $is_essential,
                'found' => $row[11],
            ]);
        }
    }
}
