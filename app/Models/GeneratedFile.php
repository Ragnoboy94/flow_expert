<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneratedFile extends Model
{
    use HasFactory;
    protected $fillable = ['demand_file_id', 'category_id', 'filename'];
}
