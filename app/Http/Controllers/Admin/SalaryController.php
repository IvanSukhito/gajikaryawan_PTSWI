<?php

namespace App\Http\Controllers\Admin;

use App\Codes\Logic\_CrudController;
use App\Codes\Models\salary;
use App\Codes\Models\Admin;
use App\Codes\Logic\ExampleLogic;
use Yajra\DataTables\DataTables;

use Illuminate\Http\Request;

class SalaryController extends _CrudController
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
            'grade_series' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'lang' => 'general.grade_series',
            ],
            'basic_salary' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'type' => 'money',  
                'lang' => 'general.basic_salary',
            ],
            'tunjangan_jabatan' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'lang' => 'general.tunjangan_jabatan',
                'list' => 0
            ],
            'tunjangan_kerajinan' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'lang' => 'general.tunjangan_kerajinan',
            ],
            'tunjangan_shift' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'lang' => 'general.tunjangan_shift',
            ],
            'tunjangan_kehadiran' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'lang' => 'general.tunjangan_kehadiran',
            ],
            'slt_day' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'lang' => 'general.slt_day',
            ],
            'bonus_produksi' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'list' => 0,
                'lang' => 'general.bonus_produksi',
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
            $request, 'general.salary', 'salary', 'salary', 'salary',
            $passingData
        );
      

         $this->listView['index'] = env('ADMIN_TEMPLATE').'.page.salary.list';
         $this->listView['import'] = env('ADMIN_TEMPLATE').'.page.salary.import';
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
            $getLogic->downloadExampleImportSalary();
        }

        $getData = $this->data;
        $data = $this->data;

        $data['thisLabel'] = __('general.salary');
        $data['viewType'] = 'create';
        $data['formsTitle'] = __('general.title_create', ['field' => __('general.salary')]);
        $data['passing'] = collectPassingData($this->passingData, $data['viewType']);
        $data['data'] = $getData;

        return view($this->listView['import'], $data);
    }

    public function storeimport(){

        ini_set('memory_limit', -1);
        ini_set('max_execution_time', -1);

        $this->callPermission();

        $adminId = session()->get('admin_id');
        $getAdmin = Admin::where('id', $adminId)->first();
        if (!$getAdmin) {
            return redirect()->route($this->rootRoute.'.' . $this->route . '.index');
        }

        $this->validate($this->request, [
            'salary' => 'required',
        ]);


        $getFile = $this->request->file('salary');

        //dd($getFile);
    
    
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
                            if($key >= 4) {
                                $nama = strip_tags(preg_replace('~[\\\\/:*?"<>|(1234567890)]~', ' ',$spreadsheet->getCell("C". $key)->getValue()));
                                $getNik = $spreadsheet->getCell("B". $key)->getValue();
                                //$getCountH = $spreadsheet->getCell("AI". $key)->getCalculatedValue();
                                $getGradeSalary = $spreadsheet->getCell("A". $key)->getValue();
                                $getBasicSalary = $spreadsheet->getCell("B". $key)->getValue();
                                $getTunjJabatan = $spreadsheet->getCell("C". $key)->getValue();
                                $getTunjKerajinan = $spreadsheet->getCell("D". $key)->getValue();
                                $getTunjShift = $spreadsheet->getCell("E". $key)->getValue();
                                $getTunjKehadiran = $spreadsheet->getCell("F". $key)->getValue();
                                $getSltperday =   $spreadsheet->getCell("G". $key)->getValue();
                                $getBonuSProduksi = $spreadsheet->getCell("H". $key)->getValue();
                             
                               
                                if(strlen($getGradeSalary)> 0 ){

                                    $salary = salary::where('grade_series', $getGradeSalary)->first();
                                    $saveMasterSalary = [
                                        'grade_series' => $getGradeSalary,
                                        'basic_salary' => $getBasicSalary,
                                        'tunjangan_jabatan' => $getTunjJabatan,
                                        'tunjangan_kerajinan' => $getTunjKerajinan,
                                        'tunjangan_shift' => $getTunjShift,
                                        'tunjangan_kehadiran' => $getTunjKehadiran,
                                        'slt_day' => $getSltperday,
                                        'bonus_produksi' => $getBonuSProduksi,
                                    ];

                               
                                    
                                    if($salary){

                                        $salary->update($saveMasterSalary);
                                    }else{
                                        
                                        
                                        salary::create($saveMasterSalary);
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
