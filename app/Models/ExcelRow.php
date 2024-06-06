<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExcelRow extends Model
{
    use HasFactory;

    protected $fillable = [
        'demand_file_id',
        'department',
        'item_name',
        'unit',
        'quantity',
        'price',
        'sum',
        'funding_source',
        'found',
        'xml_data_id',
        'release_form',
        'drug_category_id',
    ];

    public function xmlData()
    {
        return $this->belongsTo(XmlData::class);
    }
    public function drugCategory()
    {
        return $this->belongsTo(DrugCategory::class);
    }
}
