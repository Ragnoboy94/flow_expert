<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandFile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'filename', 'created_at','file_work_id', 'new_filename', 'status_id', 'count_row', 'count_accept', 'count_failed', 'error_description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function status()
    {
        return $this->belongsTo(FileStatus::class, 'status_id');
    }
}
