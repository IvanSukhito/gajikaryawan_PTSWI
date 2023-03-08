<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class karyawan extends Model
{
    use HasFactory;
    protected $table = 'karyawan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'admin_id',
        'company',
        'nama',
        'nik',
        'kartu_no',
        'dept',
        'jenis_kelamin',
        'no_ktp',
        'no_npwp',
        'no_kpj',
        'tgl_mulai_kerja',     
        'supervisor_no',
        'lama_kerja',
        'tgl_lahir',
        'tempat_lahir',
        'nama_bank',
        'no_rekening',
        'fas_kesehatan',
        'status',
        'karir',
   ];

    public function getPosition()
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }
}
