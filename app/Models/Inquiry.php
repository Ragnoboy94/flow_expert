<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'company_name', 'position', 'surname', 'name', 'phone', 'email', 'comments'
    ];

}
