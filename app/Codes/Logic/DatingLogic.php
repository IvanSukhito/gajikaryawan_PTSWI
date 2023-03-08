<?php

namespace App\Codes\Logic;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class DatingLogic
{
    public function __construct()
    {
    }

   public function generateDateToCell($tgl_terakhir){
    $endCol = '';
    
    if($tgl_terakhir == '31'){
    
        $endCol = 'AI';
    
    }elseif($tgl_terakhir == '30'){
    
        $endCol = 'AH';
    
    }elseif($tgl_terakhir == '28'){
    
        $endCol = 'AF';
    
    }


    return $endCol;
   }

   public function generateDateToCellLembur($tgl_terakhir){
    $endCol = '';
    
    if($tgl_terakhir == '31'){
    
        $endCol = 'BN';
    
    }elseif($tgl_terakhir == '30'){
    
        $endCol = 'BM';
    
    }elseif($tgl_terakhir == '28'){
    
        $endCol = 'BK';
    
    }


    return $endCol;
   }

   

}
