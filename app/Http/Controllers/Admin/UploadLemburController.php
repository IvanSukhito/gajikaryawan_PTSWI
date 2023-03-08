<?php

namespace App\Http\Controllers\Admin;

use App\Codes\Logic\_CrudController;
use App\Codes\Models\Position;
use App\Codes\Models\Admin;
use App\Codes\Models\karyawan;
use App\Codes\Models\historyLembur;
use App\Codes\Models\absenPerMonth;
use App\Codes\Logic\ExampleLogic;
use Yajra\DataTables\DataTables;
use App\Codes\Logic\DatingLogic;

use Illuminate\Http\Request;

class UploadLemburController extends _CrudController
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
            $request, 'general.upload-lembur', 'upload-lembur', 'historyLembur', 'upload-lembur',
            $passingData
        );
      
        $this->listView['create'] = env('ADMIN_TEMPLATE').'.page.upload-lembur.forms2';

    }

    public function create(){
        $this->callPermission();

        $adminId = session()->get('admin_id');
      
        if($this->request->get('download_example_import')) {
            $getLogic = new ExampleLogic();
            $getLogic->downloadExampleImportAbsensi();
        }
        $data = $this->data;

        $data['thisLabel'] = __('general.lembur');
        $data['viewType'] = 'create';
        $data['formsTitle'] = __('general.title_create', ['field' => __('general.lembur')]);
        $data['passing'] = collectPassingData($this->passingData, $data['viewType']);

        return view($this->listView[$data['viewType']], $data);
    }

    

    //function import absensi
    public function store2(){
        ini_set('memory_limit', -1);
        ini_set('max_execution_time', -1);

        $this->callPermission();

        $adminId = session()->get('admin_id');
        $getAdmin = Admin::where('id', $adminId)->first();
        if (!$getAdmin) {
            return redirect()->route($this->rootRoute.'.' . $this->route . '.index');
        }

        $this->validate($this->request, [
            'upload_lembur' => 'required',
        ]);


        $getFile = $this->request->file('upload_lembur');
        $getDate = $this->request->get('month');
        $getYear = substr($getDate, -4);
        $getMonth = date('m', strtotime(substr($getDate, 0, -5)));
        $tgl_terakhir = date('t', strtotime($getDate));
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
                            if($key >= 15) {
                               
                                $getNik = $spreadsheet->getCell("B". $key)->getOldCalculatedValue();
                            
                              
                                //dd($karyawan);
                                $getEndCols = new DatingLogic();
                                $karyawan = karyawan::where('nik', strval($getNik))->first();
                              
                                $kolomAkhir = $getEndCols->generateDateToCell($tgl_terakhir);
                                $keyAwal = 15;
                                $keyAkhir = karyawan::where('status', 1)->count()+$keyAwal-1;
                                if($key >= $keyAwal && $key <= $keyAkhir){
                                  
                                    if($karyawan && strlen($getNik) > 0){
                                        for($koloms = 'AI'; $koloms != $kolomAkhir; $koloms++){
                                           
                                            $nilai = $spreadsheet->getCell($koloms . $key)->getOldCalculatedValue();           

                                            $getTgl = $spreadsheet->getCell($koloms . 14)->getValue();

                                            $tanggal = $getYear.'-'.$getMonth.'-'.$getTgl;

                                            //dd($nilai);
                                        
                                     
                                            $saveReportLembur = [
                                            'karyawan_id' => $karyawan->id,
                                            'hari' =>  date('l', strtotime($tanggal)),
                                            'tanggal' => $tanggal,
                                            'lama_lembur' => $nilai, 
                                            ];
                                            
                                            //dd($saveReportLembur);
                                            $cekLembur = historyLembur::where('karyawan_id', $karyawan->id)->whereDate('tanggal', $tanggal)->first();

                                            if($cekLembur){
                                                $cekLembur->update($saveReportLembur);
                                            }else{
                                                historyLembur::create($saveReportLembur);
                                            }
                                        //dd($saveAbsen);
                                    
                                    
                                        }
                                    }
                                 
                                
                                }
                               
                             
                          
                            }
                        }
                    }
                }
            }
            catch(\Exception $e) {
                session()->flash('message', __('general.failed_upload_lembur'));
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
