<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class karyawan_details extends Model
{
    use HasFactory;
    protected $table = 'karyawan_details';
    protected $primaryKey = 'id';
    protected $fillable = [
        'karyawans_id',
        'title_plan',
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
        'tanggungan',
        'status_kawin',
      
   ];

    public function getKaryawan()
    {
        return $this->belongsTo(getKaryawan::class, 'karyawans_id', 'id');
    }
}
