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
                'type' => 'datepicker',
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
                'type' => 'datepicker',
                'lang' => 'general.dob',
            ],
            'gender' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'type' => 'select2',
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
                'type' => 'textarea',
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
            'keterangan' => [
                'create' => 0,
                'edit' => 0,
                'show' => 0,
                'list' => 0,
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
        $this->data['listSet']['gender'] = get_list_gender();
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
                            ->whereMonth('tanggal', '01')
                            ->get();

        $riwayatAbsenFeb = historyAbsen::selectRaw('history_absen.*')
                            ->leftjoin('karyawans', 'karyawans.id','=','history_absen.karyawan_id')
                            ->where('history_absen.karyawan_id', $id)
                            ->whereMonth('tanggal','02')
                            ->get();

        $riwayatAbsenMar = historyAbsen::selectRaw('history_absen.*')
                            ->leftjoin('karyawans', 'karyawans.id','=','history_absen.karyawan_id')
                            ->where('history_absen.karyawan_id', $id)
                            ->whereMonth('tanggal', '03')
                            ->get();

        $riwayatAbsenApr = historyAbsen::selectRaw('history_absen.*')
                            ->leftjoin('karyawans', 'karyawans.id','=','history_absen.karyawan_id')
                            ->where('history_absen.karyawan_id', $id)
                            ->whereMonth('tanggal', '04')
                            ->get();

        $riwayatAbsenMei = historyAbsen::selectRaw('history_absen.*')
                            ->leftjoin('karyawans', 'karyawans.id','=','history_absen.karyawan_id')
                            ->where('history_absen.karyawan_id', $id)
                            ->whereMonth('tanggal', '05')
                            ->get();

        $riwayatAbsenJun = historyAbsen::selectRaw('history_absen.*')
                            ->leftjoin('karyawans', 'karyawans.id','=','history_absen.karyawan_id')
                            ->where('history_absen.karyawan_id', $id)
                            ->whereMonth('tanggal', '06')
                            ->get();

        $riwayatAbsenJul = historyAbsen::selectRaw('history_absen.*')
                            ->leftjoin('karyawans', 'karyawans.id','=','history_absen.karyawan_id')
                            ->where('history_absen.karyawan_id', $id)
                            ->whereMonth('tanggal', '07')
                            ->get(); 

        $riwayatAbsenAgu = historyAbsen::selectRaw('history_absen.*')
                            ->leftjoin('karyawans', 'karyawans.id','=','history_absen.karyawan_id')
                            ->where('history_absen.karyawan_id', $id)
                            ->whereMonth('tanggal', '08')
                            ->get();      
                   
        $riwayatAbsenSep = historyAbsen::selectRaw('history_absen.*')
                            ->leftjoin('karyawans', 'karyawans.id','=','history_absen.karyawan_id')
                            ->where('history_absen.karyawan_id', $id)
                            ->whereMonth('tanggal', '09')
                            ->get();

        $riwayatAbsenOkt = historyAbsen::selectRaw('history_absen.*')
                            ->leftjoin('karyawans', 'karyawans.id','=','history_absen.karyawan_id')
                            ->where('history_absen.karyawan_id', $id)
                            ->whereMonth('tanggal', '10')
                            ->get(); 
        
        $riwayatAbsenNov = historyAbsen::selectRaw('history_absen.*')
                            ->leftjoin('karyawans', 'karyawans.id','=','history_absen.karyawan_id')
                            ->where('history_absen.karyawan_id', $id)
                            ->whereMonth('tanggal', '11')
                            ->get();  
                            
        $riwayatAbsenDec = historyAbsen::selectRaw('history_absen.*')
                            ->leftjoin('karyawans', 'karyawans.id','=','history_absen.karyawan_id')
                            ->where('history_absen.karyawan_id', $id)
                            ->whereMonth('tanggal', '12')
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
        $data['getStatusAtt'] = get_list_status_absensi();
        //dd($data['getStatusAtt']);
        return view($this->listView[$data['viewType']], $data);
    }

}
