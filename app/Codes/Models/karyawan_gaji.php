<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class karyawan_gaji extends Model
{
    use HasFactory;
    protected $table = 'karyawan_gaji';
    protected $primaryKey = 'id';
    protected $fillable = [
        'karyawans_id',
        'periode_tanggal',
        'phase_nm',
        'hire_date',
        'branch_no',
        'branch_nm',
        'basic_salary',
        'tunj_jabatan',
        'tunj_berkala',
        'tunj_shift',
        'tunj_kerajinan',
        'tunj_kehadiran',
        'tunj_transport',
        'tunj_bonus_produksi',
        'jk',
        'jkk',
        'jht',
        'jp',
        'jm',
        'akdhk',
        'igd',
        'spn',
        'jht_epl',
        'jp_epl',
        'jm_epl',
        'upah',
        'non_upah',
        'lembur',
        'thr_tahun',
        'bonus_tahun',
        'total_gaji_setahun',
        'potongan_bijab',
        'potongan_jp',
        'potongan_jht',
        'total_ptkp',
        'ptkp',
        'net_pkp',
        'pph_21',
   ];

    public function getPosition()
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }

}
