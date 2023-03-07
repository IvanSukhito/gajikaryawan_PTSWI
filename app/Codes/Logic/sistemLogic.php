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

   public function potongan_bijab($totalgajisetahun){

     $varBijab = $totalgajisetahun*0.05;
     $nilaiBijab = 6000000;
     if($varBijab > $nilaiBijab){

          return $nilaiBijab;
     }else {
          return $varBijab;
     }
   }

   public function potongan_jp($totalgajisetahun){

     $varJP = $totalgajisetahun*0.01;
     $nilaiJP = 1089312;
     if($varJP > $nilaiJP){

          return $nilaiJP;
     }else {
          return $varJP;
     }
   }

   public function render_potongan_tahunan($totalgajisetahun, $jenis){

     if($jenis == 'bijab'){

          $total = $totalgajisetahun*0.05;
          $nilai = 6000000;
          if($total > $nilai){
     
               return round($nilai);
          }else {
               return round($total);
          }

     }else if($jenis == 'jp'){

          $total = $totalgajisetahun*0.01;
          $nilai = 1089312;
          if($total > $nilai){
     
               return round($nilai);
          }else {
               return round($total);
          }

     }else if($jenis == 'jht'){
          $total = $totalgajisetahun*0.02;
             $nilai = 2400000;
             if($total > $nilai){

                  return round($nilai);
             }else {
                  return round($total);
             }
     }
     else{
          return 0;
     }
   }

   public function render_pph21($netPKP){

     $netPKP = round($netPKP);
     if($netPKP > 0 && $netPKP <= 60000000 ){
          return $netPKP*0.05;
     }else if($netPKP <=250000000){
          return 3000000+($netPKP-60000000)*0.15;
     }else if($netPKP <=500000000){
          return 31500000 +($netPKP-250000000)*0.25;
     }else if($netPKP <= 5000000000){
          return 94000000 + ($netPKP-500000000)*0.30;
     }else if($netPKP >= 5000000000){
          return 1444000000 + ($netPKP-5000000000)*0.35;
     }
     else{
          return 0;
     }
   }
   

}
