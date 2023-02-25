<?php

namespace App\Http\Controllers\Admin;

use App\Codes\Logic\_CrudController;
use App\Codes\Models\bpjs;
use Yajra\DataTables\DataTables;

use Illuminate\Http\Request;

class bpjsController extends _CrudController
{
    public function __construct(Request $request)
{
        $passingData = [
            'id' => [
                'create' => 0,
                'edit' => 0,
                'show' => 0,
                'list' => 0,
                'lang' => 'No'
            ],
            'code' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'lang' => 'general.code',
            ],
            'score' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'lang' => 'general.score',
                'type' => 'money'
            ],
            'unit' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'lang' => 'general.unit',
                
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
            $request, 'general.bpjs', 'bpjs', 'bpjs', 'bpjs',
            $passingData
        );
      
       

    }

  
}
