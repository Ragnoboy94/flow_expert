<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class XmlData extends Model
{
    use HasFactory;

    protected $fillable = [
        'search_name',
        'code',
        'mnn_norm_name',
        'dosage_norm_name',
        'lf_norm_name',
        'is_dosed',
        'is_znvlp',
        'is_narcotic',
        'trade_name',
        'pack_1_num',
        'pack_1_name',
        'pack_2_num',
        'pack_2_name',
        'consumer_total',
        'completeness',
        'owner_name',
        'owner_country_code',
        'owner_country_name',
        'num_reg',
        'date_reg',
        'manufacturer_name',
        'manufacturer_country_code',
        'manufacturer_country_name',
        'date_create',
        'date_start',
        'date_change',
        'price_value',
        'reg_date',
        'reg_num',
        'barcode'
    ];
}
