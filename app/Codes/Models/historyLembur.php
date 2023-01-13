<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class historyLembur extends Model
{
    use HasFactory;
    protected $table = 'history_lembur';
    protected $primaryKey = 'id';
    protected $fillable = [
        'karyawan_id',
        'att_start',
        'att_end',
        'lama_lembur'

    ];

   
}
