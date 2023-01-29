<?php

namespace App\Codes\Logic;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ExampleLogic
{
    public function __construct()
    {
    }

   

    public function downloadExampleImportAbsensi(){
        $file = public_path('/import/Exampleimport-Absensi.xlsx');
        //$file = asset('/import/reportabsensi.xlsx');
        $fileName = create_slugs('Example Import Absensi');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$fileName.'.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        readfile($file);
        exit();
    }
    public function downloadExampleImportBiodata(){
        $file = public_path('/import/Exampleimport-Biodata.xlsx');
        //$file = asset('/import/reportabsensi.xlsx');
        $fileName = create_slugs('Example Import Biodata');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$fileName.'.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        readfile($file);
        exit();
    }
    public function downloadExampleImportSalary(){
        $file = public_path('/import/ExampleImport-MasterSalary.xlsx');
        //$file = asset('/import/reportabsensi.xlsx');
        $fileName = create_slugs('Example Import Salary');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$fileName.'.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        readfile($file);
        exit();
    }
}
