<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tunjberkala extends Model
{
    use HasFactory;

    protected $table = 'tj_berkala';
    protected $primaryKey = 'id';
    protected $fillable = [
        'code',
        'amount',
        
    ];

   

   
  
}
