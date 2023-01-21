<?php

namespace App\Codes\Logic;
use App\Codes\Models\historyAbsen;
use App\Codes\Models\karyawan;

class AbsensiPerMonth
{
    public function __construct()
    {
    }

   
    public function getAttCount($month = 1) {
        $historyKaryawans = historyAbsen::whereMonth('tanggal', $month)->get();

      
        $dataKaryawan = karyawan::select('karyawans.id', 'karyawans.nama_pekerja')->get()->toArray();

        $n = $historyKaryawans->where('status','N');
        $h = $historyKaryawans->where('status','H');
        $sd = $historyKaryawans->where('status','SD');
        $i = $historyKaryawans->where('status','I');

        $result = [];

        foreach($dataKaryawan as $key => $val){
            $result = [
                'id' => $val['id'],
                'nama_pekerja' => $val['nama_pekerja'],
                'n' => $n->where('karyawan_id', $val['id'])->count(),
                'h' => $h->where('karyawan_id', $val['id'])->count(),
                'sd' => $sd->where('karyawan_id', $val['id'])->count(),
                'i' => $i->where('karyawan_id', $val['id'])->count(),


            ];

          
        }


        return $result;
       
    }
}
