<?php

namespace App\Http\Controllers\Admin;

use App\Codes\Logic\_CrudController;
use App\Codes\Models\Karyawan;
use App\Codes\Models\position;
use App\Codes\Models\historyAbsen;
use Yajra\DataTables\DataTables;

use Illuminate\Http\Request;

class KaryawanController extends _CrudController
{
    public function __construct(Request $request)
{
        $passingData = [
            'id' => [
                'create' => 0,
                'edit' => 0,
                'show' => 0,
                'lang' => 'No'
            ],
            'status' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'lang' => 'general.status',
                'type' => 'select2'
            ],
            'position_id' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'lang' => 'general.position',
                'type' => 'select2'
            ],
            'nama_pekerja' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'lang' => 'general.nama_pekerja',
            ],
            'nik' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'lang' => 'general.nik',
            ],
            'npwp' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'lang' => 'general.npwp',
            ],
            'tgl_masuk' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'lang' => 'general.tgl_masuk',
            ],
            'kode' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'lang' => 'general.kode',
            ],
            'dob' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'lang' => 'general.dob',
            ],
            'gender' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'lang' => 'general.gender',
            ],
            'no_hp' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'lang' => 'general.no_hp',
            ],
            'alamat' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'lang' => 'general.alamat',
            ],
            'gaji_pokok' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'type' => 'money',
                'lang' => 'general.gaji_pokok',
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
            $request, 'general.karyawan', 'karyawan', 'Karyawan', 'karyawan',
            $passingData
        );
      
       
        $position = [0 => 'Lainnya'];
        foreach(position::pluck('name', 'id')->toArray() as $key => $val){
            $position[$key] = $val;
        }

        $this->data['listSet']['status'] = get_list_active_inactive();
        $this->data['listSet']['position_id'] = $position;
        $this->listView['show'] = env('ADMIN_TEMPLATE').'.page.karyawan.forms';
    }

    public function show($id)
    {
        $this->callPermission();

        $getData = $this->crud->show($id);
        if (!$getData) {
            return redirect()->route($this->rootRoute.'.' . $this->route . '.index');
        }

        $data = $this->data;

        $riwayatAbsenJan = historyAbsen::selectRaw('history_absen.*')
                            ->leftjoin('karyawans', 'karyawans.id','=','history_absen.karyawan_id')
                            ->where('history_absen.karyawan_id', $id)
                            ->whereMonth('att_start', '01')
                            ->where('type', 1)
                            ->get();

        $riwayatAbsenFeb = historyAbsen::selectRaw('history_absen.*')
                            ->leftjoin('karyawans', 'karyawans.id','=','history_absen.karyawan_id')
                            ->where('history_absen.karyawan_id', $id)
                            ->whereMonth('att_start', '02')
                            ->whereMonth('att_end','02')
                            ->where('type', 1)
                            ->get();

        $riwayatAbsenMar = historyAbsen::selectRaw('history_absen.*')
                            ->leftjoin('karyawans', 'karyawans.id','=','history_absen.karyawan_id')
                            ->where('history_absen.karyawan_id', $id)
                            ->whereMonth('att_start', '03')
                            ->whereMonth('att_end', '03')
                            ->where('type', 1)
                            ->get();

        $riwayatAbsenApr = historyAbsen::selectRaw('history_absen.*')
                            ->leftjoin('karyawans', 'karyawans.id','=','history_absen.karyawan_id')
                            ->where('history_absen.karyawan_id', $id)
                            ->whereMonth('att_start', '04')
                            ->whereMonth('att_end', '04')
                            ->where('type', 1)
                            ->get();

        $riwayatAbsenMei = historyAbsen::selectRaw('history_absen.*')
                            ->leftjoin('karyawans', 'karyawans.id','=','history_absen.karyawan_id')
                            ->where('history_absen.karyawan_id', $id)
                            ->whereMonth('att_start', '05')
                            ->whereMonth('att_end', '05')
                            ->where('type', 1)
                            ->get();

        $riwayatAbsenJun = historyAbsen::selectRaw('history_absen.*')
                            ->leftjoin('karyawans', 'karyawans.id','=','history_absen.karyawan_id')
                            ->where('history_absen.karyawan_id', $id)
                            ->whereMonth('att_start', '06')
                            ->whereMonth('att_end', '06')
                            ->where('type', 1)
                            ->get();

        $riwayatAbsenJul = historyAbsen::selectRaw('history_absen.*')
                            ->leftjoin('karyawans', 'karyawans.id','=','history_absen.karyawan_id')
                            ->where('history_absen.karyawan_id', $id)
                            ->whereMonth('att_start', '07')
                            ->whereMonth('att_end', '07')
                            ->where('type', 1)
                            ->get(); 

        $riwayatAbsenAgu = historyAbsen::selectRaw('history_absen.*')
                            ->leftjoin('karyawans', 'karyawans.id','=','history_absen.karyawan_id')
                            ->where('history_absen.karyawan_id', $id)
                            ->whereMonth('att_start', '08')
                            ->whereMonth('att_end', '08')
                            ->where('type', 1)
                            ->get();      
                   
                            $riwayatAbsenSep = historyAbsen::selectRaw('history_absen.*')
                            ->leftjoin('karyawans', 'karyawans.id','=','history_absen.karyawan_id')
                            ->where('history_absen.karyawan_id', $id)
                            ->whereMonth('att_start', '09')
                            ->whereMonth('att_end', '09')
                            ->where('type', 1)
                            ->get();

        $riwayatAbsenOkt = historyAbsen::selectRaw('history_absen.*')
                            ->leftjoin('karyawans', 'karyawans.id','=','history_absen.karyawan_id')
                            ->where('history_absen.karyawan_id', $id)
                            ->whereMonth('att_start', '10')
                            ->whereMonth('att_end', '10')
                            ->where('type', 1)
                            ->get(); 
        
        $riwayatAbsenNov = historyAbsen::selectRaw('history_absen.*')
                            ->leftjoin('karyawans', 'karyawans.id','=','history_absen.karyawan_id')
                            ->where('history_absen.karyawan_id', $id)
                            ->whereMonth('att_start', '11')
                            ->whereMonth('att_end', '11')
                            ->where('type', 1)
                            ->get();  
                            
        $riwayatAbsenDec = historyAbsen::selectRaw('history_absen.*')
                            ->leftjoin('karyawans', 'karyawans.id','=','history_absen.karyawan_id')
                            ->where('history_absen.karyawan_id', $id)
                            ->whereMonth('att_start', '12')
                            ->whereMonth('att_end', '12')
                            ->where('type', 1)
                            ->get();      
                  
        $data['viewType'] = 'show';
        $data['formsTitle'] = __('general.title_show', ['field' => $data['thisLabel']]);
        $data['passing'] = collectPassingData($this->passingData, $data['viewType']);
        $data['data'] = $getData;
        $data['absenJan'] = $riwayatAbsenJan;
        $data['absenFeb'] = $riwayatAbsenFeb;
        $data['absenMar'] = $riwayatAbsenMar;
        $data['absenApr'] = $riwayatAbsenApr;
        $data['absenMei'] = $riwayatAbsenMei;
        $data['absenJun'] = $riwayatAbsenJun;
        $data['absenJul'] = $riwayatAbsenJul;
        $data['absenAgu'] = $riwayatAbsenAgu;
        $data['absenSep'] = $riwayatAbsenSep;
        $data['absenOkt'] = $riwayatAbsenOkt;
        $data['absenNov'] = $riwayatAbsenNov;
        $data['absenDec'] = $riwayatAbsenDec;

        return view($this->listView[$data['viewType']], $data);
    }

}
