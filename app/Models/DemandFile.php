<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandFile extends Model
{
    use HasFactory;

    protected $appends = ['status_name', 'author'];
    protected $fillable = [
        'id', 'user_id', 'filename', 'created_at', 'file_work_id', 'new_filename', 'status_id', 'count_row', 'count_accept', 'count_failed', 'error_description', 'law', 'split_into_lots'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(FileStatus::class, 'status_id');
    }

    public function getStatusNameAttribute()
    {
        return $this->status->name;
    }
    public function getAuthorAttribute()
    {
        return $this->user->name;
    }
}
