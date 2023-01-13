@extends(env('ADMIN_TEMPLATE').'._base.layout')

@section('title', __('general.title_home', ['field' => $thisLabel]))

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('assets/cms/bootstrapTreeview/bootstrap-treeview.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('general.title_home', ['field' => $thisLabel]) }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><i class="fa fa-dashboard"></i> {{ __('general.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('general.title_home', ['field' => $thisLabel]) }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                @if ($permission['create'])
                <div class="card-header">
                    <a href="<?php echo route('admin.' . $thisRoute . '.create') ?>" class="mb-2 mr-2 btn btn-success"
                       title="@lang('general.create')">
                        <i class="fa fa-plus-square"></i> @lang('general.create')
                    </a>
                </div>
                @endif
                <!-- /.card-header -->
                <div class="card-body">
                    <div id="categoryTree"></div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </section>
@stop

@section('script-bottom')
    @parent
    <script src="{{ asset('assets/cms/bootstrapTreeview/bootstrap-treeview.min.js') }}"></script>
    <script type="text/javascript">
        'use strict';
        $(document).ready(function() {
            $('#categoryTree').treeview({data: getTree()});
        });

        function getTree() {
            let data = {!! json_encode($listCategory) !!};
            return data;
        }

        function clickHere(curr) {
            window.location.href = $(curr).attr('href');
        }

    </script>
@stop
