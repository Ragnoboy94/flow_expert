<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NmckFile extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'filename', 'status_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function status()
    {
        return $this->belongsTo(FileStatus::class);
    }
}
