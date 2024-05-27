<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $appends = ['region_name'];
    protected $fillable = ['user_id', 'name', 'inn', 'kpp', 'order567', 'order450n', 'fz44', 'fz223', 'eaec',
        'completed', 'inProgress', 'terminated', 'cancelled', 'endDate', 'endDate2', 'signDate',
        'signDate2', 'region_id', 'noPenalties1', 'noPenalties2', 'excludedContracts', 'noIndexation', 'variationLimit',
        'decimalPlaces'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function getRegionNameAttribute()
    {
        return $this->region->name;
    }

}
