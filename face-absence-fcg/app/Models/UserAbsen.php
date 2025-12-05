<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAbsen extends Model
{
    use HasFactory;

    protected $table = 'data_absen';

    protected $fillable = [
        'username',
        'location',
        'status',
        'time_absen'
    ];

    protected $casts = [
        'time_absen' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(UserData::class, 'username', 'username');
    }
}