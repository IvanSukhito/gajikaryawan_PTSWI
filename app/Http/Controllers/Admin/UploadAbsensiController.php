<?php

namespace App\Http\Controllers\Admin;

use App\Codes\Logic\_CrudController;
use App\Codes\Models\Position;
use App\Codes\Models\Admin;
use App\Codes\Models\karyawan;
use App\Codes\Models\historyAbsen;
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
                            if($key >= 3) {
                                $nama = strip_tags(preg_replace('~[\\\\/:*?"<>|(1234567890)]~', ' ', $spreadsheet->getCell("A". $key)->getValue()));

                                $karyawan = karyawan::where('nama_pekerja', $nama)->first();
                                //dd($karyawan);
                                $kolomAkhir = 'AG';
                                $no = 1;
                                if($key > 2){
                                    if($nama = $karyawan){
                                        for($koloms = 'B'; $koloms != $kolomAkhir; $koloms++){
                                     
                                            $saveReportAbsen = [
                                                'karyawan_id' => $karyawan->id,
                                                'hari' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($spreadsheet->getCell($koloms . 2)->getValue())->format('dd'),
                                                'tanggal' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($spreadsheet->getCell($koloms . 2)->getValue())->format('Y-m-d'),
                                                'status' => $spreadsheet->getCell($koloms . $key)->getValue(),
                                                'weekday' => 0,
                                               
                                            ];
                                            //dd($saveAbsen);
                                            historyAbsen::create($saveReportAbsen);
                                        
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
