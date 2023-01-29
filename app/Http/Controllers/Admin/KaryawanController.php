<?php

namespace App\Http\Controllers\Admin;

use App\Codes\Logic\_CrudController;
use App\Codes\Models\karyawan;
use App\Codes\Models\karyawan_details;
use App\Codes\Models\position;
use App\Codes\Models\Admin;
use App\Codes\Logic\ExampleLogic;
use App\Codes\Models\historyAbsen;
use App\Codes\Logic\AbsensiPerMonth;
use Yajra\DataTables\DataTables;

use Illuminate\Http\Request;

class KaryawanController extends _CrudController

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
            'nama' => [
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
            'no_npwp' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'lang' => 'general.no_npwp',
            ],
            'no_ktp' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'lang' => 'general.no_ktp',
            ],
            'tgl_mulai_kerja' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'type' => 'datepicker',
                'lang' => 'general.tgl_mulai',
            ],
            'tgl_keluar_kerja' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'type' => 'datepicker',
                'list' => 0,
                'lang' => 'general.tgl_keluar',
            ],
            'tgl_lahir' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'type' => 'datepicker',
                'lang' => 'general.dob',
            ],
            'jenis_kelamin' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'type' => 'select2',
                'lang' => 'general.gender',
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

        $this->passingKaryawanDetail = generatePassingData([
            'usia' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'lang' => 'general.usia',
            ],
            'agama' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'lang' => 'general.agama',
            ],
            'level_pendidikan' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'lang' => 'general.level_pendidikan',
            ],
            'berat_badan' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'lang' => 'general.berat_badan',
            ],
            'tinggi_badan' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'lang' => 'general.tinggi_badan',
            ],

            'telephone_1' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'type' => 'phone',
                'lang' => 'general.telephone1',
            ],
            'telephone_2' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'type' => 'phone',
                'lang' => 'general.telephone2',
            ],
            'alamat_tetap' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'type' => 'textarea',
                'lang' => 'general.alamat_tetap',
            ],
            'kode_pos1' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'lang' => 'general.kode_pos1',
            ],
            'alamat_sementara' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'type' => 'textarea',
                'lang' => 'general.alamat_sementara',
            ],
            'kode_pos2' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'lang' => 'general.kode_pos2',
            ],
           
        ]);

        parent::__construct(
            $request, 'general.karyawan', 'karyawan', 'Karyawan', 'karyawan',
            $passingData
        );
      
       
        $position = [0 => 'Lainnya'];
        foreach(position::pluck('name', 'id')->toArray() as $key => $val){
            $position[$key] = $val;
        }

        $this->data['listSet']['status'] = get_list_active_inactive();
        $this->data['listSet']['jenis_kelamin'] = get_list_gender();
        $this->data['listSet']['position_id'] = $position;
        $this->listView['show'] = env('ADMIN_TEMPLATE').'.page.karyawan.forms';
        $this->listView['index'] = env('ADMIN_TEMPLATE').'.page.karyawan.list';
        $this->listView['import'] = env('ADMIN_TEMPLATE').'.page.karyawan.import';
    }

    public function show($id)
    {
        $this->callPermission();

        $getData = $this->crud->show($id);
        if (!$getData) {
            return redirect()->route($this->rootRoute.'.' . $this->route . '.index');
        }

        $data = $this->data;

        // $history = new AbsensiPerMonth(2);

        // $getHistory = $history->getAttCount();

       //dd($getHistory);
        

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
                            
        $getKaryawanDetail = karyawan_details::where('karyawans_id', $getData->id)->first();                    
                  
        $data['viewType'] = 'show';
        $data['formsTitle'] = __('general.title_show', ['field' => $data['thisLabel']]);
        $data['passing'] = collectPassingData($this->passingData, $data['viewType']);
        $data['passing_detail'] = collectPassingData($this->passingKaryawanDetail, $data['viewType']);
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
        $data['karyawanDetails'] = $getKaryawanDetail;
        //dd($data['getStatusAtt']);
        return view($this->listView[$data['viewType']], $data);
    }

    public function import(){
        $this->callPermission();

        $adminId = session()->get('admin_id');
        $getAdmin = Admin::where('id', $adminId)->first();
        if (!$getAdmin) {
            return redirect()->route($this->rootRoute.'.' . $this->route . '.index');
        }

        if($this->request->get('download_example_import')) {
            $getLogic = new ExampleLogic();
            $getLogic->downloadExampleImportBiodata();
        }

        $getData = $this->data;
        $data = $this->data;

        $data['thisLabel'] = __('general.karyawan');
        $data['viewType'] = 'create';
        $data['formsTitle'] = __('general.title_create', ['field' => __('general.karyawan')]);
        $data['passing'] = collectPassingData($this->passingData, $data['viewType']);
        $data['data'] = $getData;

        return view($this->listView['import'], $data);
    }

    public function storeimport(){
        $this->callPermission();

        $adminId = session()->get('admin_id');
        $getAdmin = Admin::where('id', $adminId)->first();
        if (!$getAdmin) {
            return redirect()->route($this->rootRoute.'.' . $this->route . '.index');
        }

        $this->validate($this->request, [
            'upload_biodata' => 'required',
        ]);
        $getFile = $this->request->file('upload_biodata');
        

        if($getFile) {
//            $destinationPath = 'synapsaapps/product/example_import';
//
//            $getUrl = Storage::put($destinationPath, $getFile);
//
//            die(env('OSS_URL') . '/' . $getUrl);

            try {
                $getFileName = $getFile->getClientOriginalName();
                $ext = explode('.', $getFileName);
                $ext = end($ext);
                if (in_array(strtolower($ext), ['xlsx', 'xls'])) {
                    $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($getFile);
                    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                    $data = $reader->load($getFile);

                    if ($data) {
                        $spreadsheet = $data->getActiveSheet();
                        foreach ($spreadsheet->getRowIterator() as $key => $row) {
                            if($key >= 2) {
                                $nama = strip_tags(preg_replace('~[\\\\/:*?"<>|(1234567890)]~', ' ',$spreadsheet->getCell("A". $key)->getValue()));
                                $getNik = $spreadsheet->getCell("B". $key)->getValue();
                                $getGender = $spreadsheet->getCell("D". $key)->getValue();
                                $getKTP = $spreadsheet->getCell("E". $key)->getValue();
                                $getNPWP = $spreadsheet->getCell("F". $key)->getValue();
                                $getKPJ = $spreadsheet->getCell("G". $key)->getValue();
                                $getTglMulaiKerja = $spreadsheet->getCell("H". $key)->getValue();
                                $getTglKeluarKerja = $spreadsheet->getCell("I". $key)->getValue();
                                $getTitlePlan = $spreadsheet->getCell("J". $key)->getValue();
                                $getSupervisorNo = $spreadsheet->getCell("K". $key)->getValue();
                                $getTanggalLahir = $spreadsheet->getCell("W". $key)->getValue();
                                $getTempatLahir = $spreadsheet->getCell("X". $key)->getValue();
                                $getUsia = $spreadsheet->getCell("Y". $key)->getValue();
                                $getAgama = $spreadsheet->getCell("Z". $key)->getValue();
                                $getLevelPendidikan = $spreadsheet->getCell("AA". $key)->getValue();
                                $getTinggi = $spreadsheet->getCell("AB". $key)->getValue();
                                $getAlamatSementara = $spreadsheet->getCell("AC". $key)->getValue();
                                $getKodePos = $spreadsheet->getCell("AD". $key)->getValue();
                                $getAlamatTetap = $spreadsheet->getCell("AE". $key)->getValue();
                                $getKodePos2 = $spreadsheet->getCell("AF". $key)->getValue();
                                $getNegara = $spreadsheet->getCell("AG". $key)->getValue();
                                $getTelp1 = $spreadsheet->getCell("AH". $key)->getValue();
                                $getTelp2 = $spreadsheet->getCell("AI". $key)->getValue();
                                $getNamaBank = $spreadsheet->getCell("AJ". $key)->getValue();
                                $getRelBank = $spreadsheet->getCell("AK". $key)->getValue();
                                $getFasKes = $spreadsheet->getCell("AL". $key)->getValue();
                                //DEduction1 Alpha, Izin, Sakit, dan HD(2)
                                //Deduction2 sum(Tl, PC, LC) lebih dari 5 x

                                $tglKeluarKerja = '';
                                if(strlen($getTglKeluarKerja) > 0){
                                    $tglKeluarKerja = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($getTglKeluarKerja)->format('Y-m-d');
                                }else{
                                    $tglKeluarKerja = null;
                                }

                               

                               

                                $saveData = [
                                    'position_id' => 0,
                                    'nama' => $nama,
                                    'nik' => $getNik,
                                    'jenis_kelamin' => $getGender,
                                    'no_ktp' => $getKTP,
                                    'no_npwp' => $getNPWP,
                                    'no_kpj' => $getKPJ,
                                    'tgl_mulai_kerja' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($getTglMulaiKerja)->format('Y-m-d'),
                                    'tgl_keluar_kerja' =>  $tglKeluarKerja,
                                    'supervisor_no' => $getSupervisorNo ?? 0,
                                    'tgl_lahir' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($getTanggalLahir)->format('Y-m-d'),
                                    'tempat_lahir' => $getTempatLahir,
                                    'status' => 1
                                ];

                                $karyawan = karyawan::where('nik', $getNik)->first();
                                //dd($getNik);
                                if($karyawan){
                                        
                                    $karyawan->update($saveData);
                                    $karyawanId = $karyawan->id;
                                    
                                }else{
                                  
                                    //dd($saveData);
                                    $dataKaryawan = karyawan::create($saveData);
                                    $karyawanId =  $dataKaryawan->id;
                                }

                                $saveKaryawanDetail = [
                                    'karyawans_id' => $karyawanId,
                                    'title_plan' => $getTitlePlan,
                                    'usia' => $getUsia,
                                    'agama' => $getAgama,
                                    'level_pendidikan' => $getLevelPendidikan,
                                    'berat_badan' => 0,
                                    'tinggi_badan' => 0,
                                    'alamat_sementara' => $getAlamatSementara,
                                    'kode_pos1' => $getKodePos,
                                    'alamat_tetap' => $getAlamatTetap,
                                    'kode_pos2' => $getKodePos2,
                                    'negara' => $getNegara,
                                    'telephone_1' => $getTelp1,
                                    'telephone_2' => $getTelp2,
                                ];

                                //dd($saveKaryawanDetail);
                                $karyawanDetail = karyawan_details::where('karyawans_id', $karyawanId)->first();
                                if($karyawanDetail){
                                    $karyawanDetail->update($saveKaryawanDetail);
                                }
                                else{
                                    karyawan_details::create($saveKaryawanDetail);
                                }
                           

                                
                             
                          
                            }
                        }
                    }
                }
            }
            catch(\Exception $e) {
                session()->flash('message', __('general.failed_upload_absensi'));
                session()->flash('message_alert', 1);
                return redirect()->route($this->rootRoute.'.' . $this->route . '.import');
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

    public function store2(){
        $this->callPermission();

        $adminId = session()->get('admin_id');
        $getAdmin = Admin::where('id', $adminId)->first();
        if (!$getAdmin) {
            return redirect()->route($this->rootRoute.'.' . $this->route . '.index');
        }

        $this->validate($this->request, [
            'upload_absensi' => 'required',
        ]);


        $getFile = $this->request->file('upload_absensi');
        $getDate = $this->request->get('month');
        $getYear = substr($getDate, -4);
        $getMonth = date('m', strtotime(substr($getDate, 0, -5)));
    
        if($getFile) {
//            $destinationPath = 'synapsaapps/product/example_import';
//
//            $getUrl = Storage::put($destinationPath, $getFile);
//
//            die(env('OSS_URL') . '/' . $getUrl);

            try {
                $getFileName = $getFile->getClientOriginalName();
                $ext = explode('.', $getFileName);
                $ext = end($ext);
                if (in_array(strtolower($ext), ['xlsx', 'xls'])) {
                    $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($getFile);
                    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                    $data = $reader->load($getFile);

                    if ($data) {
                        $spreadsheet = $data->getActiveSheet();
                        foreach ($spreadsheet->getRowIterator() as $key => $row) {
                            if($key >= 2) {
                                $nama = strip_tags(preg_replace('~[\\\\/:*?"<>|(1234567890)]~', ' ',$spreadsheet->getCell("C". $key)->getValue()));
                                $getNik = $spreadsheet->getCell("B". $key)->getValue();
                                $getCountH = $spreadsheet->getCell("AI". $key)->getCalculatedValue();
                                $getCountN = $spreadsheet->getCell("AJ". $key)->getCalculatedValue();
                                $getCountCT = $spreadsheet->getCell("AK". $key)->getCalculatedValue();
                                $getCountSD = $spreadsheet->getCell("AL". $key)->getCalculatedValue();
                                $getCountCH = $spreadsheet->getCell("AM". $key)->getCalculatedValue();
                                $getCountIR = $spreadsheet->getCell("AN". $key)->getCalculatedValue();
                                $getCountA = $spreadsheet->getCell("AO". $key)->getCalculatedValue();
                                $getCountI = $spreadsheet->getCell("AP". $key)->getCalculatedValue();
                                $getCountS = $spreadsheet->getCell("AQ". $key)->getCalculatedValue();
                                $getCountHD = $spreadsheet->getCell("AR". $key)->getCalculatedValue();
                                $getCountDL = $spreadsheet->getCell("AS". $key)->getCalculatedValue();
                                $getCountTL = $spreadsheet->getCell("AT". $key)->getCalculatedValue();
                                $getCountPC = $spreadsheet->getCell("AU". $key)->getCalculatedValue();
                                $getCountLC = $spreadsheet->getCell("AV". $key)->getCalculatedValue();
                                $getCountDed1 = $spreadsheet->getCell("AW". $key)->getCalculatedValue();
                                $getCountDed2 = $spreadsheet->getCell("AX". $key)->getCalculatedValue();
                                //DEduction1 Alpha, Izin, Sakit, dan HD(2)
                                //Deduction2 sum(Tl, PC, LC) lebih dari 5 x
                                $karyawan = karyawan::where('nik', $getNik)->first();
                                //dd($karyawan);
                                $kolomAkhir = 'AI';
                                if($key >= 2 && $key <= 11){
                                    if($karyawan){
                                        for($koloms = 'D'; $koloms != $kolomAkhir; $koloms++){
                                     
                                           
                                                $status = $spreadsheet->getCell($koloms . $key)->getValue();

                                                $getTgl = $spreadsheet->getCell($koloms . 1)->getValue();

                                                $tanggal = $getYear.'-'.$getMonth.'-'.$getTgl;
                                                $weekday = 0;
                                                if($status == 'H'){
                                                    $weekday = 1;
                                                }else{
                                                    $weekday = 0;
                                                }

                                              
                                                $saveReportAbsen = [
                                                'karyawan_id' => $karyawan->id,
                                                'hari' =>  date('l', strtotime($tanggal)),
                                                'tanggal' => $tanggal,
                                                'status' => $status,
                                                'weekday' => $weekday,
                                               
                                                ];
                                                
                                            //dd($saveAbsen);
                                            historyAbsen::create($saveReportAbsen);
                                        
                                        }
                                    } 
                                
                                }
                              

                                if($key >= 2 && $key <= 11){
                                    if($karyawan){
                                            $saveCountAbsen = [
                                                'karyawan_id' => $karyawan->id,
                                                'Month' =>  $getMonth,
                                                'Year' => $getYear,
                                                'H' => $getCountH,
                                                'N' => $getCountN,
                                                'CT' => $getCountCT,
                                                'SD' => $getCountSD,
                                                'CH' => $getCountCH,
                                                'IR' => $getCountIR,
                                                'A' => $getCountA,
                                                'I' => $getCountI,
                                                'S' => $getCountS,
                                                'HD' => $getCountHD,
                                                'DL' => $getCountDL,
                                                'TL' => $getCountTL,
                                                'PC' => $getCountPC,
                                                'LC' => $getCountLC,
                                                'Deduction_1' => $getCountDed1,
                                                'Deduction_2'=> $getCountDed2
                                               
                                                ];    
                                                //dd($saveCountAbsen); 
                                            absenPerMonth::create($saveCountAbsen);
                                        }
                                     
                                    }
                             
                          
                            }
                        }
                    }
                }
            }
            catch(\Exception $e) {
                session()->flash('message', __('general.failed_upload_absensi'));
                session()->flash('message_alert', 1);
                return redirect()->route($this->rootRoute.'.' . $this->route . '.create');
            }
        }

        if($this->request->ajax()){
            return response()->json(['result' => 1, 'message' => __('general.success_add_', ['field' => $this->data['thisLabel']])]);
        }   
        else {
            session()->flash('message', __('general.success_add_', ['field' => $this->data['thisLabel']]));
            session()->flash('message_alert', 2);
            return redirect()->route($this->rootRoute.'.' . $this->route . '.create');
        }
    }


}
