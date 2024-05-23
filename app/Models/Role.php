<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'roles';

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    protected $fillable = [
        'role',
    ];


    public function getPhoneNumberAttribute()
    {
        return $this->user->phone;
    }
}
