<?php

namespace App\Http\Controllers\Admin;

use App\Codes\Logic\_CrudController;
use App\Codes\Models\karyawan_karir;
use App\Codes\Models\karyawan;
use App\Codes\Models\karyawan_gaji;
use App\Codes\Models\karyawan_details;
use App\Codes\Models\position;
use App\Codes\Models\Admin;
use App\Codes\Models\bpjs;
use App\Codes\Models\salary;
use App\Codes\Logic\sistemLogic;
use App\Codes\Logic\ExampleLogic;
use App\Codes\Models\historyAbsen;
use App\Codes\Models\historyLembur;
use App\Codes\Models\absenPerMonth;
use App\Codes\Logic\AbsensiPerMonth;
use Yajra\DataTables\DataTables;
use DateTime;

use Illuminate\Http\Request;

class KaryawanGajiController extends _CrudController

{
    protected $passingKaryawanDetail;
    public function __construct(Request $request)
{
       

        $passingData = [
            'id' => [
                'create' => 0,
                'edit' => 0,
                'show' => 0,
                'lang' => 'No'
            ],
            'karyawans_id' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'lang' => 'general.karyawan',
                'type' => 'select2'
            ],
            'periode_tanggal' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'lang' => 'general.periode_tanggal',
               
            ],
            'basic_salary' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'type' => 'money',  
                'lang' => 'general.basic_salary',
            ],
            'tunj_jabatan' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'lang' => 'general.tunj_jabatan',
               
            ],
            'tunj_kerajinan' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'lang' => 'general.tunj_kerajinan',
            ],
            'tunj_shift' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'lang' => 'general.tunj_shift',
            ],
            'tunj_kehadiran' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'lang' => 'general.tunj_kehadiran',
            ],
            'tunj_transport' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'lang' => 'general.tunj_transport',
            ],
            'tunj_bonus_produksi' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'lang' => 'general.tunj_bonus_produksi',
            ],
            'created_at' => [
                'create' => 0,
                'edit' => 0,
                'show' => 0,
                'list' => 0,
            ],
            'action' => [
                'create' => 0,
                'edit' => 0,
                'show' => 0,
            ]
        ];


        parent::__construct(
            $request, 'general.karyawan_gaji', 'karyawan_gaji', 'Karyawan_gaji', 'karyawan_gaji',
            $passingData
        );
      
       
   
        $karyawan = [0 => 'Kosong'];
        foreach(karyawan::pluck('nama', 'id')->toArray() as $key => $val){
            $karyawan[$key] = $val;
        }

        //dd($karyawan[1]);
        $this->data['listSet']['karyawans_id'] = $karyawan;
        // $this->listView['show'] = env('ADMIN_TEMPLATE').'.page.karyawan_karir.formshowTunj';
        // $this->listView['edit'] = env('ADMIN_TEMPLATE').'.page.karyawan_karir.formshowTunj';
        // $this->listView['create'] = env('ADMIN_TEMPLATE').'.page.karyawan_karir.formscreateTunj';
        $this->listView['index'] = env('ADMIN_TEMPLATE').'.page.karyawan_gaji.list';
       
    }

    public function store(){
        
        $getDate = $this->request->get('month');
        $getYear = substr($getDate, -4);
        $getMonth = date('m', strtotime(substr($getDate, 0, -5)));

        $getAbsensi = absenPerMonth::where('Month',$getMonth)->where('Year', $getYear)->get();
        //dd(count($getAbsensi));
        //dd(count($getAbsensi));
       // dd(count($getAbsensi->where('karir',2)));
        if(count($getAbsensi) == 0){
            session()->flash('message', __('general.please_insert_attendance_first'));
            session()->flash('message_alert', 5);
            return redirect()->route($this->rootRoute.'.' . $this->route . '.index');
        }else if(count($getAbsensi->where('karir',2)) >= 1){
            session()->flash('message', __('general.salary_has_been_entered'));
            session()->flash('message_alert', 5);
            return redirect()->route($this->rootRoute.'.' . $this->route . '.index');
        }
        else{
            $getKaryawan = karyawan::where('karir', 1)->get();
            foreach($getKaryawan as $key => $val){
                $getKaryawanKarir = karyawan_karir::where('karyawans_id', $val->id)->get();
                //tunj berkala
                //cari dulu tanggal mulai kerja - patokan gaji/ periode sekarang ntr panggil functionya (buat function tunj berkala) 
                //sebenernya karyawan absensi permonth karyawan karir bisa langsung pake join
                $getTglMasuk = date('Y-m-d', strtotime($val->tgl_mulai_kerja));
    
                $getTunjBerkala = new sistemLogic();
                $tunjBerkala = $getTunjBerkala->rendertunjanganberkala($getTglMasuk);
                //buat savenya didalam sini
              
                foreach($getKaryawanKarir as $karyawan_karir){
             
                    $temp  = [
                        'karyawans_id' => $karyawan_karir->karyawans_id,
                        'tunj_berkala' => $tunjBerkala,
                        'basic_salary' => $karyawan_karir->basic_salary,
                        'tunj_jabatan' => $karyawan_karir->tunj_jabatan,
                        'tunj_shift' => $karyawan_karir->tunj_shift,
                        'tunj_kerajinan' => $karyawan_karir->tunj_kerajinan,
                        'tunj_kehadiran' => $karyawan_karir->tunj_kehadiran,
                        'tunj_transport' => $karyawan_karir->tunj_transport,
                        'tunj_bonus_produksi' => $karyawan_karir->tunj_bonus_produksi,
                        'periode_tanggal' => $getDate,
                        'jk' => $karyawan_karir->jk,
                        'jkk' => $karyawan_karir->jkk,
                        'jht' => $karyawan_karir->jht,
                        'jp' => $karyawan_karir->jp,
                        'jm' => $karyawan_karir->jm,
                        'akdhk' => $karyawan_karir->akdhk,
                        'igd' => $karyawan_karir->igd,
                        'spn' => $karyawan_karir->spn,
                        'jht_epl' => $karyawan_karir->jht_epl,
                        'jp_epl' => $karyawan_karir->jp_epl,
                        'jm_epl' => $karyawan_karir->jm_epl,
                        'ptkp' => $karyawan_karir->ptkp
                    ];
                    //$temp['ptkp'] = ['ptkp' => $karyawan_karir->ptkp];
                }
                //dd($temp);
                $GajiKaryawan[$val->id] = $temp;
    
            }
            $getAbsensi1 = $getAbsensi->where('karir',1);

            //dd($getAbsensi1);
            $storeData = [];
            foreach($getAbsensi1 as $index => $listAbsensi){
                //dd($GajiKaryawan);
                foreach($GajiKaryawan as $index2 => $listGajiKaryawan){
                    //dd($listGajiKaryawan);
                    if($listAbsensi['karyawan_id'] == $index2){
                        
                        $sumGapokTunj = $listGajiKaryawan['tunj_berkala'] +  $listGajiKaryawan['basic_salary'] + $listGajiKaryawan['tunj_jabatan'];
                        $lembur = historyLembur::where('karyawan_id', $listAbsensi->karyawan_id)->whereMonth('tanggal', $getMonth)->whereYear('tanggal', $getYear)->get();
                        $totalLembur = 0;
                        foreach($lembur as $listLembur){
                            $totalLembur += $listLembur->lama_lembur;
                        }
                        $storeData = [
                            'karyawans_id' => $listAbsensi->karyawan_id,
                            'periode_tanggal' => $getDate,
                            'tunj_berkala' => $listGajiKaryawan['tunj_berkala'],
                            'basic_salary' => $listGajiKaryawan['basic_salary'],
                            'tunj_jabatan' => $listGajiKaryawan['tunj_jabatan'],
                            'tunj_kerajinan' => round(($listGajiKaryawan['tunj_kerajinan']*$listAbsensi->Full_Att)/$listAbsensi->Working_days),
                            'tunj_shift' =>  round(($listGajiKaryawan['tunj_shift']*$listAbsensi->Full_Att)/$listAbsensi->Working_days),
                            'tunj_kehadiran' => round(($listGajiKaryawan['tunj_kehadiran']*$listAbsensi->Full_Att)/$listAbsensi->Working_days),
                            'tunj_transport' => round(($listGajiKaryawan['tunj_transport']*$listAbsensi->Working_days)),
                            'tunj_bonus_produksi' => round(($listGajiKaryawan['tunj_bonus_produksi']*$listAbsensi->bonus)),
                            'jk' => round($sumGapokTunj*$listGajiKaryawan['jk']),
                            'jkk' => round($sumGapokTunj*$listGajiKaryawan['jkk']),
                            'jht' => round($sumGapokTunj*$listGajiKaryawan['jht']),
                            'jp' => round($sumGapokTunj*$listGajiKaryawan['jp']),
                            'jm' => round($sumGapokTunj*$listGajiKaryawan['jm']),
                            'akdhk' => round($sumGapokTunj*$listGajiKaryawan['akdhk']),
                            'igd' => round($sumGapokTunj*$listGajiKaryawan['igd']),
                            'spn' => round($sumGapokTunj*$listGajiKaryawan['spn']),
                            'jht_epl' => round($sumGapokTunj*$listGajiKaryawan['jht_epl']),
                            'jp_epl' => round($sumGapokTunj*$listGajiKaryawan['jp_epl']),
                            'jm_epl' => round($sumGapokTunj*$listGajiKaryawan['jm_epl']),
                        ];
                        $storeData['upah'] =  $storeData['basic_salary']+$storeData['tunj_berkala']+$storeData['tunj_jabatan']+$storeData['tunj_kerajinan']+$storeData['tunj_shift'] ;
                        $storeData['non_upah'] = $storeData['tunj_kehadiran']+$storeData['tunj_transport']+$storeData['tunj_bonus_produksi'];
                        $storeData['lembur'] = round(($sumGapokTunj/173)*$totalLembur);//dikali jumlah hadir lembur
                        $storeData['total_gaji'] = round($storeData['upah']+$storeData['non_upah']+$storeData['lembur']);
                        //thr
                      
                        //bonus thn , rumus total gaji setahun = totgaji*12+thr+bonus
                        $storeData['total_gaji_setahun'] = round($storeData['total_gaji']*12+0+0);
                        $storeData['potongan_bijab'] = round($storeData['total_gaji_setahun']*0.05) > 6000000 ? 6000000 : round($storeData['total_gaji_setahun']*0.05);
                        $storeData['potongan_jp'] =  round($storeData['total_gaji_setahun']*0.01) > 1089312 ?  1089312 : round($storeData['total_gaji_setahun']*0.01);
                        $storeData['potongan_jht'] =  round($storeData['total_gaji_setahun']*0.02) > 2400000 ? 2400000 : round($storeData['total_gaji_setahun']*0.02);
                        $storeData['total_pkp'] = $storeData['total_gaji_setahun']-$storeData['potongan_bijab']-$storeData['potongan_jp']-$storeData['potongan_jht'];
                        $storeData['ptkp'] = $listGajiKaryawan['ptkp'];
                        $netPkp = $storeData['total_pkp']-$storeData['ptkp'];
                        $storeData['net_pkp'] = round($netPkp) > 0 ? round($netPkp) : 0;
                        $pph21 = new sistemLogic();
                        $storeData['pph_21'] = round($pph21->render_pph21($storeData['net_pkp']));
                    }
                  

                  
                }
             
                    //dd($storeData);
                $storeData = karyawan_gaji::create($storeData);
                $listAbsensi->update(['karir' => 2]);
               
            }

         


        }
    
        if($this->request->ajax()){
            return response()->json(['result' => 1, 'message' => __('general.success_add_', ['field' => $this->data['thisLabel']])]);
        }
        else {
            session()->flash('message', __('general.success_add_', ['field' => $this->data['thisLabel']]));
            session()->flash('message_alert', 2);
            return redirect()->route($this->rootRoute.'.' . $this->route . '.index');
        }

    }

   
}
