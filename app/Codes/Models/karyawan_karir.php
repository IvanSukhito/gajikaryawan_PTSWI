<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class karyawan_karir extends Model
{
    use HasFactory;
    protected $table = 'karyawan_karir';
    protected $primaryKey = 'id';
    protected $fillable = [
        'karyawans_id',
        'kode_basic_salary',
        'kode_tunjangan',
        'basic_salary',
        'tunj_jabatan',
        'tunj_shift',
        'tunj_kerajinan',
        'tunj_kehadiran',
        'tunj_transport',
        'tunj_bonus_prod',
        'bpjs_jk',
        'bpjs_jkk',
        'bpjs_jht',
        'bpjs_jp',
        'bpjs_m',
        'akdhk',
        'igd',
        'spn',
        'jht_epl',
        'jp_epl',
        'jm_epl',
        'ptkp',

      
   ];

    public function getKaryawan()
    {
        return $this->belongsTo(getKaryawan::class, 'karyawans_id', 'id');
    }
}
