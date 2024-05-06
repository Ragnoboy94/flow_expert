<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandFile extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'filename', 'created_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
