<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineDrugPrice extends Model
{
    use HasFactory;
    protected $fillable = [
        'drug_name',
        'online_price',
    ];
}
