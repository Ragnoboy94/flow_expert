<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodicData extends Model
{
    use HasFactory;
    protected $table = 'periodic_data';

    protected $fillable = [
        'user_id',
        'period_id',
        'quantity'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
