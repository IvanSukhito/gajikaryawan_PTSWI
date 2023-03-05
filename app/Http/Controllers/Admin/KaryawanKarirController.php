<?php

namespace App\Http\Controllers\Admin;

use App\Codes\Logic\_CrudController;
use App\Codes\Models\karyawan_karir;
use App\Codes\Models\karyawan;
use App\Codes\Models\karyawan_details;
use App\Codes\Models\position;
use App\Codes\Models\Admin;
use App\Codes\Models\bpjs;
use App\Codes\Models\absenPerMonth;
use App\Codes\Models\salary;
use App\Codes\Logic\sistemLogic;
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
            'karyawans_id' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'lang' => 'general.karyawan',
                'type' => 'select2'
            ],
            'kode_basic_salary' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'lang' => 'general.kode_basic_salary',
                'list' => 0,
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
            $request, 'general.karyawan_karir', 'karyawan_karir', 'Karyawan_karir', 'karyawan_karir',
            $passingData
        );
      
       
   
        $karyawan = [0 => 'Kosong'];
        foreach(karyawan::pluck('nama', 'id')->toArray() as $key => $val){
            $karyawan[$key] = $val;
        }

        //dd($karyawan[1]);
        $this->data['listSet']['karyawans_id'] = $karyawan;
        $this->listView['show'] = env('ADMIN_TEMPLATE').'.page.karyawan_karir.formshowTunj';
        $this->listView['edit'] = env('ADMIN_TEMPLATE').'.page.karyawan_karir.formshowTunj';
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
        foreach(karyawan::where('karir',0)->pluck('nama', 'id')->toArray() as $key => $val){
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
   
        $listTunjJS = [];
        foreach(salary::where('tunjangan_jabatan', '>', 0)->get(['id','tunjangan_jabatan'])->toArray() as $key => $val){
            $listTunjJS[$val['id']] = $val['tunjangan_jabatan'];
        }
        $data['formsTitle'] = __('general.title_create', ['field' => $data['thisLabel']]);
        $data['passing'] = collectPassingData($this->passingData, $data['viewType']);
        $data['datakaryawan'] = $karyawan;
        $data['datasalary'] = $salary;
        $data['datatunj_jabatan'] = $tunjJabatan;
        $data['listsalary'] = salary::get();
        $data['listtunj'] = $listTunjJS;
        $data['listBPJSPC'] = bpjs::where('paid_company',1)->get(['id','score','code']);
        $data['listBPJSPE'] = bpjs::where('paid_employee',1)->get(['id','score','code']);
        return view($this->listView[$data['viewType']], $data);
    }

    public function store()
    {
        $this->callPermission();

        $viewType = 'create';

        $this->validate($this->request, [
            'basic_salary' => 'required',
            'tunj_jabatan' => 'required',
            'tunj_kerajinan' => 'required',
            'tunj_shift' => 'required',
            'tunj_kehadiran' => 'required',
            'tunj_transport' => 'required',
            'tunj_bonus_produksi' => 'required',
            'JK' => 'required',
            'JKK' => 'required',
            'JP' => 'required',
            'JM' => 'required',
            'JHT' => 'required',
            'AKDHK' => 'required',
            'IGD' => 'required',
            'SPN' => 'required',
            'JHT_epl' => 'required',
            'JP_epl' => 'required',
            'JM_epl' => 'required',
            'status_kawin' => 'required',
            'jumlah_tanggungan' => 'required',
        ]);
        $status_kawin = strtolower($this->request->get('status_kawin'));
        $jumlah_tanggungan = $this->request->get('jumlah_tanggungan');

        $searchPTKP = new sistemLogic();
        $ptkp = $searchPTKP->getPTKP($status_kawin, $jumlah_tanggungan);
        $karyawanID = $this->request->get('karyawans_id');
        //dd($this->request->all());
        $tunjangan = new karyawan_karir();
        $tunjangan->karyawans_id = $karyawanID;
        $tunjangan->kode_basic_salary = $this->request->get('kode_basic_salary');
        $tunjangan->kode_tunjangan = $this->request->get('kode_tunjangan');
        $tunjangan->basic_salary = clear_money_format($this->request->get('basic_salary'));
        $tunjangan->tunj_jabatan = clear_money_format($this->request->get('tunj_jabatan'));
        $tunjangan->tunj_kerajinan = clear_money_format($this->request->get('tunj_kerajinan'));
        $tunjangan->tunj_shift = clear_money_format($this->request->get('tunj_shift'));
        $tunjangan->tunj_kehadiran = clear_money_format($this->request->get('tunj_kehadiran'));
        $tunjangan->tunj_transport = clear_money_format($this->request->get('tunj_transport'));
        $tunjangan->tunj_bonus_produksi = clear_money_format($this->request->get('tunj_bonus_produksi'));
        $tunjangan->JK = clear_money_format($this->request->get('JK'));
        $tunjangan->JKK = clear_money_format($this->request->get('JKK'));
        $tunjangan->JHT = clear_money_format($this->request->get('JHT'));
        $tunjangan->JP = clear_money_format($this->request->get('JP'));
        $tunjangan->JM = clear_money_format($this->request->get('JM'));
        $tunjangan->AKDHK = clear_money_format($this->request->get('AKDHK'));
        $tunjangan->IGD = clear_money_format($this->request->get('IGD'));
        $tunjangan->SPN = clear_money_format($this->request->get('SPN'));
        $tunjangan->jht_epl = clear_money_format($this->request->get('JHT_epl'));
        $tunjangan->jp_epl = clear_money_format($this->request->get('JP_epl'));
        $tunjangan->jm_epl = clear_money_format($this->request->get('JM_epl'));
        $tunjangan->kode_ptkp = $ptkp['code'];
        $tunjangan->ptkp = $ptkp['amount'];
        $tunjangan->save();

        $karyawan = karyawan::where('id', $karyawanID)->update([
            'karir' => 1
        ]);

        $absen = absenPerMonth::where('karyawan_id', $karyawanID)->update([
            'karir' => 1
        ]);

        $karyawans_details = karyawan_details::where('karyawans_id', $karyawanID)->update([
            'tanggungan' => $jumlah_tanggungan,
            'status_kawin' => $status_kawin,
        ]);

        $id = $tunjangan->id;
    
        //cara panggil ptkp $ptkp['code'] $ptkp['amount']
        if($this->request->ajax()){
            return response()->json(['result' => 1, 'message' => __('general.success_add_', ['field' => $this->data['thisLabel']])]);
        }
        else {
            session()->flash('message', __('general.success_add_', ['field' => $this->data['thisLabel']]));
            session()->flash('message_alert', 2);
            return redirect()->route($this->rootRoute.'.' . $this->route . '.show', $id);
        }
    }

    public function show($id)
    {
        $this->callPermission();

        $getData = $this->crud->show($id);
        if (!$getData) {
            return redirect()->route($this->rootRoute.'.' . $this->route . '.index');
        }

        $data = $this->data;
        //dd($getData);

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
   
        $listTunjJS = [];
        foreach(salary::where('tunjangan_jabatan', '>', 0)->get(['id','tunjangan_jabatan'])->toArray() as $key => $val){
            $listTunjJS[$val['id']] = $val['tunjangan_jabatan'];
        }    

        $data['viewType'] = 'show';
        $data['formsTitle'] = __('general.title_show', ['field' => $data['thisLabel']]);
        $data['passing'] = collectPassingData($this->passingData, $data['viewType']);
        $data['data'] = $getData;
        $data['datakaryawan'] = $karyawan;
        $data['datasalary'] = $salary;
        $data['datatunj_jabatan'] = $tunjJabatan;
        $data['listsalary'] = salary::get();
        $data['listtunj'] = $listTunjJS;
        $data['listPTKP'] = karyawan_details::where('karyawans_id', $getData->karyawans_id)->first();
        $data['listBPJSPC'] = bpjs::where('paid_company',1)->get(['id','score','code']);
        $data['listBPJSPE'] = bpjs::where('paid_employee',1)->get(['id','score','code']);
        return view($this->listView[$data['viewType']], $data);

    

    }

    public function edit($id)
    {
        $this->callPermission();

        $getData = $this->crud->show($id);
        if (!$getData) {
            return redirect()->route($this->rootRoute.'.' . $this->route . '.index');
        }

        $data = $this->data;
        //dd($getData);

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
   
        $listTunjJS = [];
        foreach(salary::where('tunjangan_jabatan', '>', 0)->get(['id','tunjangan_jabatan'])->toArray() as $key => $val){
            $listTunjJS[$val['id']] = $val['tunjangan_jabatan'];
        }
          
        $data['viewType'] = 'edit';
        $data['formsTitle'] = __('general.title_show', ['field' => $data['thisLabel']]);
        $data['passing'] = collectPassingData($this->passingData, $data['viewType']);
        $data['data'] = $getData;
        $data['datakaryawan'] = $karyawan;
        $data['datasalary'] = $salary;
        $data['datatunj_jabatan'] = $tunjJabatan;
        $data['listsalary'] = salary::get();
        $data['listtunj'] = $listTunjJS;
        $data['listPTKP'] = karyawan_details::where('karyawans_id', $getData->karyawans_id)->first();
        $data['listBPJSPC'] = bpjs::where('paid_company',1)->get(['id','score','code']);
        $data['listBPJSPE'] = bpjs::where('paid_employee',1)->get(['id','score','code']);
        return view($this->listView[$data['viewType']], $data);

    

    }

    public function update($id)
    {
        $this->callPermission();

        $viewType = 'edit';

       
        $getData = $this->crud->show($id);
        if (!$getData) {
            return redirect()->route($this->rootRoute.'.' . $this->route . '.index');
        }

        $status_kawin = strtolower($this->request->get('status_kawin'));
        $jumlah_tanggungan = $this->request->get('jumlah_tanggungan');

        $searchPTKP = new sistemLogic();
        $ptkp = $searchPTKP->getPTKP($status_kawin, $jumlah_tanggungan);

        $getData->karyawans_id = $getData->karyawans_id;
        $getData->kode_basic_salary = $this->request->get('kode_basic_salary');
        $getData->kode_tunjangan = $this->request->get('kode_tunjangan');
        $getData->basic_salary = clear_money_format($this->request->get('basic_salary'));
        $getData->tunj_jabatan = clear_money_format($this->request->get('tunj_jabatan'));
        $getData->tunj_kerajinan = clear_money_format($this->request->get('tunj_kerajinan'));
        $getData->tunj_shift = clear_money_format($this->request->get('tunj_shift'));
        $getData->tunj_kehadiran = clear_money_format($this->request->get('tunj_kehadiran'));
        $getData->tunj_transport = clear_money_format($this->request->get('tunj_transport'));
        $getData->tunj_bonus_produksi = clear_money_format($this->request->get('tunj_bonus_produksi'));
        $getData->JK = clear_money_format($this->request->get('JK'));
        $getData->JKK = clear_money_format($this->request->get('JKK'));
        $getData->JHT = clear_money_format($this->request->get('JHT'));
        $getData->JP = clear_money_format($this->request->get('JP'));
        $getData->JM = clear_money_format($this->request->get('JM'));
        $getData->AKDHK = clear_money_format($this->request->get('AKDHK'));
        $getData->IGD = clear_money_format($this->request->get('IGD'));
        $getData->SPN = clear_money_format($this->request->get('SPN'));
        $getData->jht_epl = clear_money_format($this->request->get('JHT_epl'));
        $getData->jp_epl = clear_money_format($this->request->get('JP_epl'));
        $getData->jm_epl = clear_money_format($this->request->get('JM_epl'));
        $getData->kode_ptkp = $ptkp['code'];
        $getData->ptkp = $ptkp['amount'];
        
        $getData->save();
        $id = $getData->id;

        $karyawan = karyawan::where('id', $getData->karyawans_id)->update([
            'karir' => 1
        ]);

        $absen = absenPerMonth::where('karyawan_id',  $getData->karyawans_id)->update([
            'karir' => 1
        ]);

        $karyawans_details = karyawan_details::where('karyawans_id', $getData->karyawans_id)->update([
            'tanggungan' => $jumlah_tanggungan,
            'status_kawin' => $status_kawin,
        ]);

        if($this->request->ajax()){
            return response()->json(['result' => 1, 'message' => __('general.success_edit_', ['field' => $this->data['thisLabel']])]);
        }
        else {
            session()->flash('message', __('general.success_edit_', ['field' => $this->data['thisLabel']]));
            session()->flash('message_alert', 2);
            return redirect()->route($this->rootRoute.'.' . $this->route . '.show', $id);
        }
    }
}
