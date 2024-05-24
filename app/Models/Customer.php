<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'inn', 'kpp', 'order567', 'order450n', 'fz44', 'fz223', 'eaec',
        'completed', 'inProgress', 'terminated', 'cancelled', 'endDate', 'endDate2', 'signDate',
        'signDate2', 'region', 'noPenalties1', 'noPenalties2', 'excludedContracts', 'noIndexation', 'variationLimit',
        'decimalPlaces'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
