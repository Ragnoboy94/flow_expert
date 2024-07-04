<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Organization extends Model
{
    use CrudTrait;
    use HasFactory;
    protected $fillable = [
        'name', 'juridical_address', 'postal_address', 'inn', 'account_number',
        'bank_account', 'bik', 'ogrn', 'email', 'phone', 'status_id', 'paid_until',
        'confirmation_uuid', 'confirmed_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->confirmation_uuid = (string) Str::uuid();
        });
    }

    public function status()
    {
        return $this->belongsTo(OrganizationStatus::class, 'status_id');
    }
    public function positions()
    {
        return $this->hasMany(Position::class);
    }
}
