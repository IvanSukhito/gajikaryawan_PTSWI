<?php
switch ($viewType) {
    case 'edit': $printCard = 'card-success'; break;
    case 'create': $printCard = 'card-primary'; break;
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
                        <li class="breadcrumb-item"><a href="<?php echo route('admin.' . $thisRoute . '.index') ?>"> {{ __('general.import', ['field' => $thisLabel]) }}</a></li>
                        <li class="breadcrumb-item active">@lang('general.upload_absensi')</li>
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
                    <h3 class="card-title">@lang('general.upload_absensi')</h3>
                </div>
                <!-- /.card-header -->

                @if(in_array($viewType, ['create']))
                    {{ Form::open(['route' => ['admin.' . $thisRoute . '.store2'], 'files' => true, 'id'=>'form', 'role' => 'form'])  }}
                @elseif(in_array($viewType, ['edit']))
                    {{ Form::open(['route' => ['admin.' . $thisRoute . '.update', $data->{$masterId}], 'method' => 'PUT', 'files' => true, 'id'=>'form', 'role' => 'form'])  }}
                @else
                    {{ Form::open(['id'=>'form', 'role' => 'form'])  }}
                @endif

                <div class="card-body">
                    <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example_upload_absensi">{{ __('general.example_upload_absensi') }} <span class="text-red">*</span></label><br />
                            <a href="?download_example_import=1"
                                class="btn btn-sm btn-primary" title="{{ __('general.download') }}" id="example_upload_absensi">
                            <i class="fa fa-file-excel-o"></i><span class=""> {{ __('general.download') }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="choose_month">{{ __('general.choose_month') }} <span class="text-red">*</span></label><br />
                            <select name="month" class="form-control select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="month" tabindex="-1" aria-hidden="true">
                                <option selected="selected" data-select2-id="'{{date('F Y', strtotime(date("Y-m-d")))}}" value="{{date('F Y', strtotime(date("Y-m-d")))}}">{{date('F Y', strtotime(date("Y-m-d")))}}</option>
                                <option data-select2-id="{{date('F Y', strtotime("-1 month", strtotime(date("Y-m-d"))))}}" value="{{date('F Y', strtotime("-1 month", strtotime(date("Y-m-d"))))}}">{{date('F Y', strtotime("-1 month", strtotime(date("Y-m-d"))))}}</option>
                            </select>
                        </div>
                    </div>
                </div>

            

                    <div class="form-group">
                        <label for="upload_absensi">{{ __('general.upload_absensi') }} <span class="text-red">*</span></label>
                        {{ Form::file('upload_absensi', ['class' => $errors->has('upload_absensi') ? 'form-control dropify is-invalid' : 'form-control dropify', 'id' => 'upload_absensi', 'required' => true, 'autocomplete' => 'off', 'accept' => '.xls, .xlsx']) }}
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">

                    @if(in_array($viewType, ['create']))
                        <button type="submit" class="mb-2 mr-2 btn btn-primary" title="@lang('general.save')">
                            <i class="fa fa-save"></i><span class=""> @lang('general.upload')</span>
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
        $(document).ready(function() {
            $('.dropify').dropify();
        });
     </script>
@stop
