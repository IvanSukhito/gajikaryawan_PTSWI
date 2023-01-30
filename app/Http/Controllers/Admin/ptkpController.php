<?php

namespace App\Http\Controllers\Admin;

use App\Codes\Logic\_CrudController;
use App\Codes\Models\ptkp;
use Yajra\DataTables\DataTables;

use Illuminate\Http\Request;

class ptkpController extends _CrudController
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
            'amount' => [
                'validate' => [
                    'create' => 'required',
                    'edit' => 'required'
                ],
                'lang' => 'general.amount',
                'type' => 'money'
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
            $request, 'general.ptkp', 'ptkp', 'ptkp', 'ptkp',
            $passingData
        );
      
       

    }

  
}
