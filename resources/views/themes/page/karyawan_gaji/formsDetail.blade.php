<?php
switch ($viewType) {
    case 'create': $printCard = 'card-success'; break;
    case 'edit': $printCard = 'card-primary'; break;
    default: $printCard = 'card-info'; break;
}
if (in_array($viewType, ['show'])) {
    $addAttribute = [
        'disabled' => true
    ];
}
else {
    $addAttribute = [
    ];
}
?>
@extends(env('ADMIN_TEMPLATE').'._base.layout')

@section('title', $formsTitle)

@section('css')
    @parent
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('script-top')
    @parent
    <script>
        CKEDITOR_BASEPATH = '/assets/cms/js/ckeditor/';
    </script>
@stop

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $thisLabel }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><i class="fa fa-dashboard"></i> {{ __('general.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo route('admin.' . $thisRoute . '.index') ?>"> {{ __('general.title_home', ['field' => $thisLabel]) }}</a></li>
                        <li class="breadcrumb-item active">{{ $formsTitle }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card {!! $printCard !!}">
                <div class="card-header">
                    <h3 class="card-title">{{ $formsTitle }}</h3>
                </div>
                <!-- /.card-header -->

                @if(in_array($viewType, ['create']))
                    {{ Form::open(['route' => ['admin.' . $thisRoute . '.store'], 'files' => true, 'id'=>'form', 'role' => 'form'])  }}
                @elseif(in_array($viewType, ['edit']))
                    {{ Form::open(['route' => ['admin.' . $thisRoute . '.update', $data->{$masterId}], 'method' => 'PUT', 'files' => true, 'id'=>'form', 'role' => 'form'])  }}
                @else
                    {{ Form::open(['id'=>'form', 'role' => 'form'])  }}
                @endif

                <div class="card-body">
                    @include(env('ADMIN_TEMPLATE').'._component.generate_forms')
                </div>

          
                <!-- /.card-body -->
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="data1" width="100%">
                        <thead>
                        <tr>
                            <th></th>
                       
                            @for($i = 1; $i<=count($listAbsensi); $i++)
                            <th class="small"><b>{{$i}}</b></th>
                            @endfor
                            <!-- <th>@lang('general.doctor_id')</th>
                            <th>@lang('general.service_id')</th>
                            <th>@lang('general.weekday')</th>
                            <th>@lang('general.time_start')</th>
                            <th>@lang('general.time_end')</th>
                            <th>@lang('general.book')</th> -->
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>@lang('general.absensi')</td>
                            @foreach($listAbsensi as $absen)
                            @if($absen->status == 'H')
                            <td class="small"><p style="color:red;">{{$absen->status}}</p></td>
                            @else
                            <td class="small">{{$absen->status}}</td>
                            @endif
                            @endforeach
                      
                 
                        </tr>
                        <tr>
                            <td>@lang('general.lembur')</td>
                            @foreach($listLembur as $lembur)
                            <td class="small">{{$lembur->lama_lembur}}</td>
                            @endforeach
                      
                 
                        </tr>
                     
                        </tbody>
                    </table>
                </div>

                <div class="card-footer">

                    @if(in_array($viewType, ['create']))
                        <button type="submit" class="mb-2 mr-2 btn btn-success" title="@lang('general.save')">
                            <i class="fa fa-save"></i><span class=""> @lang('general.save')</span>
                        </button>
                    @elseif (in_array($viewType, ['edit']))
                        <button type="submit" class="mb-2 mr-2 btn btn-primary" title="@lang('general.update')">
                            <i class="fa fa-save"></i><span class=""> @lang('general.update')</span>
                        </button>
                    @elseif (in_array($viewType, ['show']) && $permission['edit'] == true)
                        <a href="<?php echo route('admin.' . $thisRoute . '.edit', $data->{$masterId}) ?>"
                           class="mb-2 mr-2 btn btn-primary" title="{{ __('general.edit') }}">
                            <i class="fa fa-pencil"></i><span class=""> {{ __('general.edit') }}</span>
                        </a>
                    @endif
                    <a href="<?php echo route('admin.' . $thisRoute . '.index') ?>" class="mb-2 mr-2 btn btn-warning"
                       title="{{ __('general.back') }}">
                        <i class="fa fa-arrow-circle-o-left"></i><span class=""> {{ __('general.back') }}</span>
                    </a>

                </div>

                {{ Form::close() }}

            </div>
        </div>
    </section>



@stop

@section('script-bottom')
    @parent
    @include(env('ADMIN_TEMPLATE').'._component.generate_forms_script')
    <script>
            'use strict';
   
            $(document).ready( function () {

        let table;
        table = jQuery('#data1').DataTable({
            pageLength: 5,
            autoWidth: true,
            scrollX: true,
            scrollY: '50vh',
            scrollCollapse: true,
            paging: false,
            aaSorting: [ {!! "[0,'asc']" !!}],
            rowReorder: {
                selector: 'td:nth-child(3)'
            },
            responsive: true,
        });
    });
    </script>
@stop
