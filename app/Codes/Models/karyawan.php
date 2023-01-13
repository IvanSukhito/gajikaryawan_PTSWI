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
        'nama_pekerja',
        'nik',
        'npwp',
        'tgl_masuk',
        'kode',
        'dob',
        'gender',
        'no_hp',
        'alamat',
        'gaji_pokok',
        'keterangan',
        'status'

    ];

    public function getPosition()
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }
}
