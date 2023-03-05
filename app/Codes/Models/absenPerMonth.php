<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class absenPerMonth extends Model
{
    use HasFactory;
    protected $table = 'absen_permonth';
    protected $primaryKey = 'id';
    protected $fillable = [
        'karyawan_id',
        'Month',
        'Year',
        'H',
        'N',
        'CT',
        'SD',
        'CH',
        'IR',
        'A',
        'I',
        'S',
        'HD',
        'DL',
        'TL',
        'PC',
        'LC',
        'karir',
        'Deduction_1',
        'Deduction_2',
        'Working_days',
        'Full_Att',
        'Bonus',

    ];

   
}
