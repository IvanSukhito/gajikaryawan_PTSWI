<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bpjs extends Model
{
    use HasFactory;

    protected $table = 'bpjs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'code',
        'score',
        'unit',
        'paid_employee',
        'paid_company',
    
        
    ];

  
}
