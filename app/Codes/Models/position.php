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
        'salary'
    ];

    protected $appends = [
        'salary_nice',
    ];


    public function getKaryawan()
    {
        return $this->hasMany(Karyawan::class, 'position_id', 'id');
    }
    public function getSalaryNiceAttribute()
    {
        return intval($this->salary) > 0 ? number_format($this->salary, 0, ',', '.') : 0;
    }
    
}
