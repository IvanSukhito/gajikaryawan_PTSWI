<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salary extends Model
{
    use HasFactory;

    protected $table = 'salary';
    protected $primaryKey = 'id';
    protected $fillable = [
        'grade_series',
        'basic_salary',
        'tunjangan_jabatan',
        'tunjangan_kerajinan',
        'tunjangan_shift',
        'tunjangan_kehadiran',
        'slt_day',
        'bonus_produksi',
    ];

 

    
    
}
