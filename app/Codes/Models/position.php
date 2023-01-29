<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class position extends Model
{
    use HasFactory;

    protected $table = 'position';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        
    ];

   

    public function getKaryawan()
    {
        return $this->hasMany(Karyawan::class, 'position_id', 'id');
    }
  
}
