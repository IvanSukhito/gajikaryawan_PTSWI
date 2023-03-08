<?php

namespace App\Http\Controllers\Admin;

use App\Codes\Logic\_CrudController;
use App\Codes\Models\Position;
use App\Codes\Models\Admin;
use App\Codes\Models\karyawan;
use App\Codes\Models\historyAbsen;
use App\Codes\Models\historyLembur;
use App\Codes\Models\absenPerMonth;
use App\Codes\Logic\ExampleLogic;
use App\Codes\Logic\DatingLogic;
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
        $data['formsTitle'] = __('general.title_create', ['field' => __('general.absensi')]);
        $data['passing'] = collectPassingData($this->passingData, $data['viewType']);

        return view($this->listView[$data['viewType']], $data);
    }

    

    //function import absensi
    public function store2(){
        ini_set('memory_limit', -1);
        ini_set('max_execution_time', 10000);
        ini_set('set_time_limit', 3600);

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


        $tgl_terakhir = date('t', strtotime($getDate));
        $getEndCols = new DatingLogic();

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
                                $getNik = $spreadsheet->getCell("B". $key)->getOldCalculatedValue();
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
                                $getCountDed1 = $spreadsheet->getCell("AX". $key)->getCalculatedValue();
                                $getCountDed2 = $spreadsheet->getCell("AY". $key)->getCalculatedValue();
                               
                                $getWorkAtt = $spreadsheet->getCell("AW". $key)->getCalculatedValue();
                                $getBonus = substr($spreadsheet->getCell("BD". $key)->getCalculatedValue(), -1);

                                // $highestRow = $spreadsheet->getRowIterator(); // e.g 'F'
                                // $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5

                                // dd($highestRow);


                                //Deduction1 Alpha, Izin, Sakit, dan HD(2)
                                //Deduction2 sum(Tl, PC, LC) lebih dari 5 x
                              
                              
                                
                                //key awal = data diambil dari kolom mulai ke berapa
                                //key akhir = data terakhir diambil dari kolom akhir ke berapa
                                $keyAwal = 2;
                                $keyAkhir = karyawan::where('status', 1)->count()+$keyAwal-1;
                                $karyawan = karyawan::where('nik', strval($getNik))->first();
                            

                                $kolomAkhir = $getEndCols->generateDateToCell($tgl_terakhir);
                                if($key >= $keyAwal && $key <= $keyAkhir){
                                 
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
                                                
                                                $cekAbsensi = historyAbsen::where('karyawan_id', $karyawan->id)->whereDate('tanggal', $tanggal)->first();

                                                //dd($cekAbsensi);
                                                if(strlen($cekAbsensi) > 0){
                                                    $cekAbsensi->update($saveReportAbsen);
                                                }else{
                                                    historyAbsen::create($saveReportAbsen);
                                                }
                                            //dd($saveAbsen);
                                        
                                        
                                        }
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
                                            'karir' => 1,
                                            'Deduction_1' => $getCountDed1,
                                            'Deduction_2'=> $getCountDed2,
                                            'Working_days' => $getWorkAtt,
                                            'Full_Att' => 26,
                                            'Bonus' => intval($getBonus),
                                            ];    
                                         
                                        $cekTotalAbsensi = absenPerMonth::where('karyawan_id', $karyawan->id)->whereMonth('Month', $getMonth)->whereYear('Year', $getYear)->first();

                                    
                                        if(strlen($cekTotalAbsensi) > 0){
                                            $cektotalAbsensi->update($saveCountAbsen);
                                        }else{
                                            absenPerMonth::create($saveCountAbsen);
                                        }
                                    } 
                                
                                }

                            

                                $keyAwal2 = $keyAkhir+2;
                                //dd($keyAwal2);
                                $keyAkhir2 = karyawan::where('status', 1)->count()+$keyAwal2-1;
                                $kolomAkhir2 = $getEndCols->generateDateToCellLembur($tgl_terakhir);
                                if($key >= $keyAwal2 && $key <= $keyAkhir2){
                                  
                                    if($karyawan && strlen($getNik) > 0){
                                        for($koloms2 = 'AI'; $koloms2 != $kolomAkhir2; $koloms2++){
                                           
                                            $nilai = $spreadsheet->getCell($koloms2 . $key)->getOldCalculatedValue();           

                                            $getTgl2 = $spreadsheet->getCell($koloms2 . $keyAwal2+1)->getValue();

                                            $tanggal2 = $getYear.'-'.$getMonth.'-'.$getTgl2;

                                            //dd($nilai);
                                        
                                     
                                            $saveReportLembur = [
                                            'karyawan_id' => $karyawan->id,
                                            'hari' =>  date('l', strtotime($tanggal2)),
                                            'tanggal' => $tanggal2,
                                            'lama_lembur' => $nilai, 
                                            ];
                                            
                                            //dd($saveReportLembur);
                                            $cekLembur = historyLembur::where('karyawan_id', $karyawan->id)->whereDate('tanggal', $tanggal2)->first();

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
