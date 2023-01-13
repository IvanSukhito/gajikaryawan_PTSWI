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

            @if(in_array($viewType, ['create']))
                {{ Form::open(['route' => ['admin.' . $thisRoute . '.store'], 'files' => true, 'id'=>'form', 'role' => 'form'])  }}
            @elseif(in_array($viewType, ['edit']))
                {{ Form::open(['route' => ['admin.' . $thisRoute . '.update', $data->{$masterId}], 'method' => 'PUT', 'files' => true, 'id'=>'form', 'role' => 'form'])  }}
            @else
                {{ Form::open(['id'=>'form', 'role' => 'form'])  }}
            @endif


                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-3">

                                <!-- Profile Image -->
                                <div class="card card-primary card-outline">
                                    <div class="card-body box-profile">
                                        <div class="text-center">
                                        
                                                <img class="profile-user-img img-fluid img-circle" src="{{ asset('/users/user-default.png') }}" alt="User profile picture">
                                          
                                        </div>

                                        <h3 class="profile-username text-center">{{ $data->nama_pekerja }}</h3>

                                        <p class="text-muted text-center">{{ $data->dob }}</p>

                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                <b>Total Absen</b> <a class="float-right"></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Total Lembur </b> <a class="float-right"></a>
                                            </li>
                                        </ul>

                                            <div class="text-center badge-primary"><b></b></div>

                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->

                                <!-- About Me Box -->
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">About Me</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <strong>NIK</strong>

                                        <p class="text-muted">
                                           {{ $data->nik }}
                                        </p>

                                        <hr>

                                        <strong>NPWP</strong>

                                        <p class="text-muted"> {{ $data->npwp}}</p>

                                        <hr>

                                        <strong>Phone </strong>

                                        <p class="text-muted">{{$data->no_hp}}</p>

                                        <hr>

                                        <strong>Alamat </strong>

                                        <br>
                                        <p class="text-muted">{{$data->alamat}} </p>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-header p-2">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item"><a class="nav-link active" href="#biodata" data-toggle="tab">@lang('Biodata')</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#absen-month" data-toggle="tab">@lang('Riwayat Absen')</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#appointment" data-toggle="tab">@lang('Riwayat Lembur')</a></li>
                                        </ul>
                                    </div><!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="biodata">
                                                @include(env('ADMIN_TEMPLATE').'._component.generate_forms')
                                            </div>
                                            <!-- /.tab-pane -->
                                            <div class="tab-pane" id="absen-month">
                                                <!-- Transaction -->
                                                <ul class="nav nav-pills">
                                                    <li class="nav-item"><a class="nav-link" href="#jan" data-toggle="tab">@lang('general.jan')</a></li>
                                                    <li class="nav-item"><a class="nav-link active" href="#feb" data-toggle="tab">@lang('general.feb')</a></li>
                                                    <li class="nav-item"><a class="nav-link" href="#mar" data-toggle="tab">@lang('general.mar')</a></li>
                                                    <li class="nav-item"><a class="nav-link" href="#apr" data-toggle="tab">@lang('general.apr')</a></li>
                                                    <li class="nav-item"><a class="nav-link " href="#mei" data-toggle="tab">@lang('general.mei')</a></li>
                                                    <li class="nav-item"><a class="nav-link" href="#jun" data-toggle="tab">@lang('general.jun')</a></li>
                                                    <li class="nav-item"><a class="nav-link" href="#jul" data-toggle="tab">@lang('general.jul')</a></li>
                                                    <li class="nav-item"><a class="nav-link" href="#agt" data-toggle="tab">@lang('general.agt')</a></li>
                                                    <li class="nav-item"><a class="nav-link " href="#sep" data-toggle="tab">@lang('general.sep')</a></li>
                                                    <li class="nav-item"><a class="nav-link" href="#okt" data-toggle="tab">@lang('general.okt')</a></li>
                                                    <li class="nav-item"><a class="nav-link" href="#nov" data-toggle="tab">@lang('general.nov')</a></li>
                                                    <li class="nav-item"><a class="nav-link" href="#dec" data-toggle="tab">@lang('general.dec')</a></li>
                                                </ul>

                                                <div class="tab-content">
                                                    <div class="tab-pane" id="jan">

                                                        <br>
                                                        <table class="table table-bordered table-striped" id="dataM1" style="width: 1000">

                                                            <thead>
                                                            <tr>
                                                           
                                                                <th>@lang('general.hari')</th>
                                                                <th>@lang('general.time_start')</th>
                                                                <th>@lang('general.time_end')</th>
                                                                <th>@lang('general.att_start')</th>
                                                                <th>@lang('general.att_end')</th>
                                                          
                                                              
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($absenJan as $list)
                                                                <tr>
                                                              
                                                                    <td>{{$list->hari}}</td>
                                                                    <td>{{$list->time_start}}</td>
                                                                    <td>{{$list->time_end}}</td>
                                                                    <td>{{$list->att_start}}</td>
                                                                    <td>{{$list->att_end}}</td>
                                                               
                                                                </tr>
                                                          
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane active" id="feb">

                                                        <br>
                                                        <table class="table table-bordered table-striped" id="dataM2">
                                                        <thead>
                                                            <tr>
                                                         
                                                                <th>@lang('general.hari')</th>
                                                                <th>@lang('general.time_start')</th>
                                                                <th>@lang('general.time_end')</th>
                                                                <th>@lang('general.att_start')</th>
                                                                <th>@lang('general.att_end')</th>
                                                          
                                                              
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($absenFeb as $list)
                                                                <tr>
                                                               
                                                                    <td>{{$list->hari}}</td>
                                                                    <td>{{$list->time_start}}</td>
                                                                    <td>{{$list->time_end}}</td>
                                                                    <td>{{$list->att_start}}</td>
                                                                    <td>{{$list->att_end}}</td>
                                                               
                                                                </tr>
                                                          
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane" id="mar">

                                                        <br>
                                                        <table class="table table-bordered table-striped" id="dataM3">
                                                        <thead>
                                                            <tr>
                                                              
                                                                <th>@lang('general.hari')</th>
                                                                <th>@lang('general.time_start')</th>
                                                                <th>@lang('general.time_end')</th>
                                                                <th>@lang('general.att_start')</th>
                                                                <th>@lang('general.att_end')</th>
                                                          
                                                              
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($absenMar as $list)
                                                                <tr>
                                                              
                                                                    <td>{{$list->hari}}</td>
                                                                    <td>{{$list->time_start}}</td>
                                                                    <td>{{$list->time_end}}</td>
                                                                    <td>{{$list->att_start}}</td>
                                                                    <td>{{$list->att_end}}</td>
                                                               
                                                                </tr>
                                                          
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane" id="apr">

                                                        <br>
                                                        <table class="table table-bordered table-striped" id="dataM4">

                                                        <thead>
                                                            <tr>
                                                                <th>@lang('general.hari')</th>
                                                                <th>@lang('general.time_start')</th>
                                                                <th>@lang('general.time_end')</th>
                                                                <th>@lang('general.att_start')</th>
                                                                <th>@lang('general.att_end')</th>    
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($absenApr as $list)
                                                                <tr>
                                                                    <td>{{$list->id}}</td>
                                                                    <td>{{$list->hari}}</td>
                                                                    <td>{{$list->time_start}}</td>
                                                                    <td>{{$list->time_end}}</td>
                                                                    <td>{{$list->att_start}}</td>
                                                                    <td>{{$list->att_end}}</td>
                                                                </tr>
                                                          
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane" id="mei">

                                                        <br>
                                                        <table class="table table-bordered table-striped" id="dataM5">
                                                        <thead>
                                                            <tr>
                                                                <th>@lang('general.hari')</th>
                                                                <th>@lang('general.time_start')</th>
                                                                <th>@lang('general.time_end')</th>
                                                                <th>@lang('general.att_start')</th>
                                                                <th>@lang('general.att_end')</th>    
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($absenMei as $list)
                                                                <tr>
                                                                    <td>{{$list->id}}</td>
                                                                    <td>{{$list->hari}}</td>
                                                                    <td>{{$list->time_start}}</td>
                                                                    <td>{{$list->time_end}}</td>
                                                                    <td>{{$list->att_start}}</td>
                                                                    <td>{{$list->att_end}}</td>
                                                                </tr>
                                                          
                                                            @endforeach
                                                            </tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane" id="jun">

                                                        <br>
                                                        <table class="table table-bordered table-striped" id="dataM6">

                                                        <thead>
                                                            <tr>
                                                                <th>@lang('general.hari')</th>
                                                                <th>@lang('general.time_start')</th>
                                                                <th>@lang('general.time_end')</th>
                                                                <th>@lang('general.att_start')</th>
                                                                <th>@lang('general.att_end')</th>    
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($absenJun as $list)
                                                                <tr>
                                                                    <td>{{$list->id}}</td>
                                                                    <td>{{$list->hari}}</td>
                                                                    <td>{{$list->time_start}}</td>
                                                                    <td>{{$list->time_end}}</td>
                                                                    <td>{{$list->att_start}}</td>
                                                                    <td>{{$list->att_end}}</td>
                                                                </tr>
                                                          
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane" id="jul">

                                                        <br>
                                                        <table class="table table-bordered table-striped" id="dataM7">

                                                        <thead>
                                                            <tr>
                                                                <th>@lang('general.hari')</th>
                                                                <th>@lang('general.time_start')</th>
                                                                <th>@lang('general.time_end')</th>
                                                                <th>@lang('general.att_start')</th>
                                                                <th>@lang('general.att_end')</th>    
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($absenJul as $list)
                                                                <tr>
                                                                    <td>{{$list->id}}</td>
                                                                    <td>{{$list->hari}}</td>
                                                                    <td>{{$list->time_start}}</td>
                                                                    <td>{{$list->time_end}}</td>
                                                                    <td>{{$list->att_start}}</td>
                                                                    <td>{{$list->att_end}}</td>
                                                                </tr>
                                                          
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane" id="agt">

                                                        <br>
                                                        <table class="table table-bordered table-striped" id="dataM8">
                                                        <thead>
                                                            <tr>
                                                                <th>@lang('general.hari')</th>
                                                                <th>@lang('general.time_start')</th>
                                                                <th>@lang('general.time_end')</th>
                                                                <th>@lang('general.att_start')</th>
                                                                <th>@lang('general.att_end')</th>    
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($absenAgu as $list)
                                                                <tr>
                                                                    <td>{{$list->id}}</td>
                                                                    <td>{{$list->hari}}</td>
                                                                    <td>{{$list->time_start}}</td>
                                                                    <td>{{$list->time_end}}</td>
                                                                    <td>{{$list->att_start}}</td>
                                                                    <td>{{$list->att_end}}</td>
                                                                </tr>
                                                          
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane" id="sep">

                                                        <br>
                                                        <table class="table table-bordered table-striped" id="dataM9">
                                                        <thead>
                                                            <tr>
                                                                <th>@lang('general.hari')</th>
                                                                <th>@lang('general.time_start')</th>
                                                                <th>@lang('general.time_end')</th>
                                                                <th>@lang('general.att_start')</th>
                                                                <th>@lang('general.att_end')</th>    
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($absenSep as $list)
                                                                <tr>
                                                                    <td>{{$list->id}}</td>
                                                                    <td>{{$list->hari}}</td>
                                                                    <td>{{$list->time_start}}</td>
                                                                    <td>{{$list->time_end}}</td>
                                                                    <td>{{$list->att_start}}</td>
                                                                    <td>{{$list->att_end}}</td>
                                                                </tr>
                                                          
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane" id="okt">

                                                        <br>
                                                        <table class="table table-bordered table-striped" id="dataM10">
                                                        <thead>
                                                            <tr>
                                                                <th>@lang('general.hari')</th>
                                                                <th>@lang('general.time_start')</th>
                                                                <th>@lang('general.time_end')</th>
                                                                <th>@lang('general.att_start')</th>
                                                                <th>@lang('general.att_end')</th>    
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($absenOkt as $list)
                                                                <tr>
                                                                    <td>{{$list->id}}</td>
                                                                    <td>{{$list->hari}}</td>
                                                                    <td>{{$list->time_start}}</td>
                                                                    <td>{{$list->time_end}}</td>
                                                                    <td>{{$list->att_start}}</td>
                                                                    <td>{{$list->att_end}}</td>
                                                                </tr>
                                                          
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane" id="nov">

                                                        <br>
                                                        <table class="table table-bordered table-striped" id="dataM11">
                                                        <thead>
                                                            <tr>
                                                                <th>@lang('general.hari')</th>
                                                                <th>@lang('general.time_start')</th>
                                                                <th>@lang('general.time_end')</th>
                                                                <th>@lang('general.att_start')</th>
                                                                <th>@lang('general.att_end')</th>    
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($absenNov as $list)
                                                                <tr>
                                                                    <td>{{$list->id}}</td>
                                                                    <td>{{$list->hari}}</td>
                                                                    <td>{{$list->time_start}}</td>
                                                                    <td>{{$list->time_end}}</td>
                                                                    <td>{{$list->att_start}}</td>
                                                                    <td>{{$list->att_end}}</td>
                                                                </tr>
                                                          
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane" id="dec">

                                                        <br>
                                                        <table class="table table-bordered table-striped" id="dataM12">
                                                        <thead>
                                                            <tr>
                                                                <th>@lang('general.hari')</th>
                                                                <th>@lang('general.time_start')</th>
                                                                <th>@lang('general.time_end')</th>
                                                                <th>@lang('general.att_start')</th>
                                                                <th>@lang('general.att_end')</th>    
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($absenDec as $list)
                                                                <tr>
                                                                    <td>{{$list->id}}</td>
                                                                    <td>{{$list->hari}}</td>
                                                                    <td>{{$list->time_start}}</td>
                                                                    <td>{{$list->time_end}}</td>
                                                                    <td>{{$list->att_start}}</td>
                                                                    <td>{{$list->att_end}}</td>
                                                                </tr>
                                                          
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- /.tab-pane -->

                                            <div class="tab-pane" id="appointment">
                                                <!-- /.appointment -->
                                               

                                                <div class="tab-content">
                                                  
                                                  
                                                        <br>
                                                        <table class="table table-bordered table-striped" id="dataA2">

                                                            <thead>
                                                            <tr>
                                                                <th>@lang('general.id')</th>
                                                                <th>@lang('general.att_start')</th>
                                                                <th>@lang('general.att_end')</th>
                                                                <th>@lang('general.lama_lembur')</th>
                                                          
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                        
                                                                <tr>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                 
                                                                </tr>
                                                        
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- /.tab-pane -->
                                        </div>
                                        <!-- /.tab-content -->
                                    </div><!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>

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
    </section>

@stop

@section('script-bottom')
    @parent
    @include(env('ADMIN_TEMPLATE').'._component.generate_forms_script')
    <script type="text/javascript">
        'use strict';
        let table;
        table = jQuery('#dataM1, #dataM2, #dataM3, #dataM4, #dataM5, #dataM6, #dataM7, #dataM8, #dataM9, #dataM10, #dataM11, #dataM12').DataTable({
            pageLength: 5,
            autoWidth: false,
            scrollX: false,
            aaSorting: [ {!! "[0,'desc']" !!}],
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true
        });
        table = jQuery('#dataA1, #dataA2').DataTable({
            pageLength: 5,
            autoWidth: false,
            scrollX: false,
            responsive: true,
            aaSorting: [ {!! "[0,'desc']" !!}],
        });
    </script>
@stop
