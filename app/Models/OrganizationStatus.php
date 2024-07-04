<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationStatus extends Model
{
    use CrudTrait;
    use HasFactory;
    protected $fillable = [
        'id',
        'name'
    ];
    public function organizations()
    {
        return $this->hasMany(Organization::class, 'status_id');
    }
}
