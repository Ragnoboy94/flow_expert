<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineRows extends Model
{
    use HasFactory;
    protected $fillable = [
        'offer_id',
        'mnn',
        'name',
        'trade_name',
        'form',
        'quantity',
        'price',
        'total'
    ];
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}
