<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $appends = ['file_status_name'];
    protected $fillable = [
        'sender',
        'date',
        'positions',
        'file_path',
        'excel_file_path',
        'file_status_id',
        'exel_exported_at'
    ];

    public function fileStatus()
    {
        return $this->belongsTo(FileStatus::class, 'file_status_id');
    }

    public function getFileStatusNameAttribute()
    {
        return $this->fileStatus->name;
    }
    public function medicineRows()
    {
        return $this->hasMany(MedicineRows::class);
    }
}
