<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ptkp extends Model
{
    use HasFactory;

    protected $table = 'ptkp';
    protected $primaryKey = 'id';
    protected $fillable = [
        'code',
        'amount',
        
    ];

  
}
