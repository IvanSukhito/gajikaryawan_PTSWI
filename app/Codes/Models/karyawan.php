<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class karyawan extends Model
{
    use HasFactory;
    protected $table = 'karyawans';
    protected $primaryKey = 'id';
    protected $fillable = [
        'position_id',
        'nama',
        'nik',
        'jenis_kelamin',
        'no_ktp',
        'no_npwp',
        'no_kpj',
        'tgl_mulai_kerja',
        'tgl_keluar_kerja',
        'title_plan',
        'supervisor_no',
        'tgl_lahir',
        'tempat_lahir',
        'usia',
        'agama',
        'level_pendidikan',
        'berat_badan',
        'tinggi_badan',
        'alamat_sementara',
        'kode_pos1',
        'alamat_tetap',
        'kode_pos2',
        'negara',
        'telephone_1',
        'telephone_2',
        'nama_bank',
        'no_rekening',
        'fas_kesehatan',
        'status',
   ];

    public function getPosition()
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }
}
