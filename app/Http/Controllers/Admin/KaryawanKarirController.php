<?php

namespace App\Http\Controllers\Admin;

use App\Codes\Logic\_CrudController;
use App\Codes\Models\karyawan_karir;
use App\Codes\Models\karyawan;
use App\Codes\Models\karyawan_details;
use App\Codes\Models\position;
use App\Codes\Models\Admin;
use App\Codes\Models\salary;
use App\Codes\Logic\ExampleLogic;
use App\Codes\Models\historyAbsen;
use App\Codes\Logic\AbsensiPerMonth;
use Yajra\DataTables\DataTables;

use Illuminate\Http\Request;

class KaryawanKarirController extends _CrudController

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
            'karyawan_id' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'lang' => 'general.karyawan',
                'type' => 'select2'
            ],
            'nama' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'lang' => 'general.nama_pekerja',
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
            $request, 'general.karyawan_karir', 'karyawan_karir', 'Karyawan_karir', 'karyawan_karir',
            $passingData
        );
      
       
        $position = [0 => 'Lainnya'];
        foreach(position::pluck('name', 'id')->toArray() as $key => $val){
            $position[$key] = $val;
        }


        
        $this->data['listSet']['status'] = get_list_active_inactive();
        $this->data['listSet']['jenis_kelamin'] = get_list_gender();
        $this->data['listSet']['position_id'] = $position;
        // $this->listView['show'] = env('ADMIN_TEMPLATE').'.page.karyawan.forms';
        $this->listView['create'] = env('ADMIN_TEMPLATE').'.page.karyawan_karir.formscreateTunj';
        //$this->listView['index'] = env('ADMIN_TEMPLATE').'.page.karyawan.list';
       
    }

    public function create()
    {
        $this->callPermission();

        $data = $this->data;
        //besok kasih status tunj karyawan kalo 0 belum diisi kalo 1 udah
       
        $data['viewType'] = 'create';

        $karyawan = [0 => 'Kosong'];
        foreach(karyawan::pluck('nama', 'id')->toArray() as $key => $val){
            $karyawan[$key] = $val;
        }
        $salary = [];
        foreach(salary::get(['id','basic_salary','grade_series'])->toArray() as $key => $val){
            $salary[$val['id']] = $val['grade_series'].' - '.  number_format($val['basic_salary'], 0, ',', '.');
        }

        $tunjJabatan = [];
        foreach(salary::where('tunjangan_jabatan', '>', 0)->get(['id','tunjangan_jabatan','grade_series'])->toArray() as $key => $val){
            $tunjJabatan[$val['id']] = $val['grade_series'].' - '.  number_format($val['tunjangan_jabatan'], 0, ',', '.');
        }
    
        // $listSalaryJS = [];
        // foreach(salary::get(['id','basic_salary'])->toArray() as $key => $val){
        //     $listSalaryJS[$val['id']] = number_format($val['basic_salary'], 0, ',', '.');
        // }
        $listSalaryJS = salary::get();
       
        $listTunjJS = [];
        foreach(salary::where('tunjangan_jabatan', '>', 0)->get(['id','tunjangan_jabatan'])->toArray() as $key => $val){
            $listTunjJS[$val['id']] = number_format($val['tunjangan_jabatan'], 0, ',', '.');
        }

        //dd($listTunjJS);
        $data['formsTitle'] = __('general.title_create', ['field' => $data['thisLabel']]);
        $data['passing'] = collectPassingData($this->passingData, $data['viewType']);
        $data['datakaryawan'] = $karyawan;
        $data['datasalary'] = $salary;
        $data['datatunj_jabatan'] = $tunjJabatan;
        $data['listsalary'] = $listSalaryJS;
        $data['listtunj'] = $listTunjJS;

        return view($this->listView[$data['viewType']], $data);
    }

    public function store()
    {
        $this->callPermission();

        $viewType = 'create';

        dd($this->request->all());

        if($this->request->ajax()){
            return response()->json(['result' => 1, 'message' => __('general.success_add_', ['field' => $this->data['thisLabel']])]);
        }
        else {
            session()->flash('message', __('general.success_add_', ['field' => $this->data['thisLabel']]));
            session()->flash('message_alert', 2);
            return redirect()->route($this->rootRoute.'.' . $this->route . '.show', $id);
        }
    }
}
