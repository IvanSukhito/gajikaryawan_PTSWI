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
        'supervisor_no',
        'tgl_lahir',
        'tempat_lahir',
        'status',
   ];

    public function getPosition()
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }
}
