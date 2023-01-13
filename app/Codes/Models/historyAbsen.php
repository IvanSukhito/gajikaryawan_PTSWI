<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class historyAbsen extends Model
{
    use HasFactory;
    protected $table = 'history_absen';
    protected $primaryKey = 'id';
    protected $fillable = [
        'karyawan_id',
        'hari',
        'time_start',
        'time_end',
        'att_start',
        'att_end',
        'type',
        'weekday'

    ];

   
}
