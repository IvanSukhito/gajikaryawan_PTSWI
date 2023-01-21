<?php

namespace App\Http\Controllers\Admin;

use App\Codes\Logic\_CrudController;
use App\Codes\Models\Position;
use App\Codes\Models\Admin;
use App\Codes\Models\karyawan;
use App\Codes\Models\historyAbsen;
use App\Codes\Models\absenPerMonth;
use App\Codes\Logic\ExampleLogic;
use Yajra\DataTables\DataTables;

use Illuminate\Http\Request;

class UploadAbsensiController extends _CrudController
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
            'name' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'lang' => 'general.position_name',
            ],
            'salary' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],

                'type' => 'money',
                'lang' => 'general.salary',
                'custom' => ', name: "salary"'
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
            $request, 'general.upload-absensi', 'upload-absensi', 'historyAbsen', 'upload-absensi',
            $passingData
        );
      
        $this->listView['create'] = env('ADMIN_TEMPLATE').'.page.upload-absensi.forms2';

    }

    public function create(){
        $this->callPermission();

        $adminId = session()->get('admin_id');
      
        if($this->request->get('download_example_import')) {
            $getLogic = new ExampleLogic();
            $getLogic->downloadExampleImportAbsensi();
        }
        $data = $this->data;

        $data['thisLabel'] = __('general.absensi');
        $data['viewType'] = 'create';
        $data['formsTitle'] = __('general.title_create');
        $data['passing'] = collectPassingData($this->passingData, $data['viewType']);

        return view($this->listView[$data['viewType']], $data);
    }

    public function create2(){
        $this->callPermission();

        $adminId = session()->get('admin_id');
        $getAdmin = Admin::where('id', $adminId)->first();
        if (!$getAdmin) {
            return redirect()->route($this->rootRoute.'.' . $this->route . '.index');
        }

        if($this->request->get('download_example_import')) {
            $getLogic = new ExampleLogic();
            $getLogic->downloadExampleImportProduct();
        }

        $getData = $this->data;
        $data = $this->data;

        $data['thisLabel'] = __('general.product');
        $data['viewType'] = 'create';
        $data['formsTitle'] = __('general.title_create', ['field' => __('general.product')]);
        $data['passing'] = collectPassingData($this->passingData, $data['viewType']);
        $data['data'] = $getData;

        return view($this->listView['create2'], $data);
    }

    //function import absensi
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
                                $karyawan = karyawan::where('nama_pekerja', $nama)->first();
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
