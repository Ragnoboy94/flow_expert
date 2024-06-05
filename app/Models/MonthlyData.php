<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyData extends Model
{
    use HasFactory;
    protected $table = 'monthly_data';

    protected $fillable = [
        'user_id',
        'month_id',
        'price',
        'quantity'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
