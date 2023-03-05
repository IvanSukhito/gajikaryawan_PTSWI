<?php

namespace App\Codes\Logic;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\Codes\Models\ptkp;
use App\Codes\Models\tunjberkala;
use DateTime;
class sistemLogic
{
    public function __construct()
    {
    }

   public function getPTKP($status_kawin, $jumlah_tanggungan){
    
    //$ptkp = ptkp::get();
    $getPTKP = [];
    foreach(ptkp::get(['id','code','amount'])->toArray() as $key => $val){
        $getPTKP[$val['id']] = ['code' => $val['code'],
                            'amount' => $val['amount']];
    }

    $result = '';
    //logicnya masukin statusnya kalau sesuai keluarin kode_ptkpnya sama amountnya
   if($status_kawin == 'tidak kawin' && $jumlah_tanggungan == 0){
        $result = $getPTKP[1];
   }
   else if($status_kawin == 'tidak kawin' && $jumlah_tanggungan == 1){
        $result = $getPTKP[2];
   }
   else if($status_kawin == 'tidak kawin' && $jumlah_tanggungan == 2){
        $result = $getPTKP[3];
        
   }
   else if($status_kawin == 'tidak kawin' && $jumlah_tanggungan >= 3){
      $result = $getPTKP[4];
    
   }
   else if($status_kawin == 'kawin' && $jumlah_tanggungan == 0){
       $result = $getPTKP[5];
        
   }
   else if($status_kawin == 'kawin' && $jumlah_tanggungan == 1){
       $result = $getPTKP[6];
   }
   else if($status_kawin == 'kawin' && $jumlah_tanggungan == 2){
        $result = $getPTKP[7];
        
   }
   else if($status_kawin == 'kawin' && $jumlah_tanggungan >= 3){
        $result = $getPTKP[8];
       
   }
   
   
  
    return $result;
   }

  
   public function rendertunjanganberkala($getTglMasuk){

     $getTjBerkala = [];
     foreach(tunjberkala::get(['id','code','amount'])->toArray() as $key => $val){
         $getTjBerkala[$val['id']] = ['code' => $val['code'],
                             'amount' => $val['amount']];
     }

     $tglMasuk =  new DateTime($getTglMasuk);
     $today = new DateTime();

     $lamaKerja = $tglMasuk->diff($today)->y;

        $hasil = 0;
          foreach($getTjBerkala as $TunjBerkala){
               if($lamaKerja == $TunjBerkala['code']){
                    $amount = $TunjBerkala['amount'];
               }
          }
         
     $hasil = $amount;

     return $hasil;
          
  
      
   }
   

}
