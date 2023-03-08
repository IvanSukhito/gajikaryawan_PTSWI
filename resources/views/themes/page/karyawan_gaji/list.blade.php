@extends(env('ADMIN_TEMPLATE').'._base.layout')

@section('title', __('general.title_home', ['field' => $thisLabel]))

@section('css')
    @parent
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
        <div class="row">
                <div class="col-md-7">
                    <div class="card">
          
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                <button type="submit" class="btn btn-block btn-success " id="buat-gaji"><i class="nav-icon fa fa-file-excel-o">&nbsp;Export Current</i></button>
                                </div>
                                <div class="col-6">
                                <button type="submit" class="btn btn-block btn-success " id="buat-gaji"><i class="nav-icon fa fa-plus-square">&nbsp;Export All</i></button>
                                </div>
                            
                            </div>   
                        </div>
                        <!-- /.card-body -->
                        <!--/.col md-->
                        </div>
                        <div class="card">

                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped" id="data1">
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <!--/.col md-->
                        </div>
                </div>
                <!--/col 2 -->

                
                <div class="col-md-5">
                    <div class="card">

                    <!-- /.card-header -->
                    <form method="post" action="{{ route('admin.karyawan_gaji.store') }}" id="store" onsubmit = 'return askingSubmit()'>
                        @csrf

                    <div class="card-body">
                    <p>Auto Input Salary </p>
                    <div class="row">

                    <div class="col-7">
                        <div class="form-group">
                                <select name="month" id="period-month" class="form-control select2" style="width: 100%;" data-select2-id="month" tabindex="-1" aria-hidden="true">
                                    <option selected="selected" data-select2-id="'{{date('F Y', strtotime(date("Y-m-d")))}}" value="{{date('F Y', strtotime(date("Y-m-d")))}}">{{date('F Y', strtotime(date("Y-m-d")))}}</option>
                                    <option data-select2-id="{{date('F Y', strtotime("-1 month", strtotime(date("Y-m-d"))))}}" value="{{date('F Y', strtotime("-1 month", strtotime(date("Y-m-d"))))}}">{{date('F Y', strtotime("-1 month", strtotime(date("Y-m-d"))))}}</option>
                                </select>
                        </div>
                    </div>
                    <div class="col-5">
                            <button type="submit" class="mb-2 mr-2 btn btn-danger" id="buat-gaji">Buat Gaji</button>
                    </div>
                    </div>  <!-- /.row --> 
                    </div><!-- /.card-body -->
                    <!-- input manual -->

                    </form>
                    <!-- /.card-body -->

                    <!--/.col md-->
                    </div>
                <!-- input manual fix -->
                    <div class="card">

                            <!-- /.card-header -->
                            <form method="post" action="{{ route('admin.karyawan_gaji.store') }}" id="store" onsubmit = 'return askingSubmit()'>
                                @csrf

                            <div class="card-body">
                            <p>Manual Input Salary </p>
                            <div class="row">

                            <div class="col-5">
                                <div class="form-group">
                                        <select name="month" id="period-month" class="form-control select2" style="width: 100%;" data-select2-id="month" tabindex="-1" aria-hidden="true">
                                            <option selected="selected" data-select2-id="'{{date('F Y', strtotime(date("Y-m-d")))}}" value="{{date('F Y', strtotime(date("Y-m-d")))}}">{{date('F Y', strtotime(date("Y-m-d")))}}</option>
                                            <option data-select2-id="{{date('F Y', strtotime("-1 month", strtotime(date("Y-m-d"))))}}" value="{{date('F Y', strtotime("-1 month", strtotime(date("Y-m-d"))))}}">{{date('F Y', strtotime("-1 month", strtotime(date("Y-m-d"))))}}</option>
                                        </select>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-group">
                                        <select name="month" id="period-month" class="form-control select2" style="width: 100%;" data-select2-id="month" tabindex="-1" aria-hidden="true">
                                            <option selected="selected" data-select2-id="'{{date('F Y', strtotime(date("Y-m-d")))}}" value="{{date('F Y', strtotime(date("Y-m-d")))}}">{{date('F Y', strtotime(date("Y-m-d")))}}</option>
                                        <option data-select2-id="{{date('F Y', strtotime("-1 month", strtotime(date("Y-m-d"))))}}" value="{{date('F Y', strtotime("-1 month", strtotime(date("Y-m-d"))))}}">{{date('F Y', strtotime("-1 month", strtotime(date("Y-m-d"))))}}</option>
                                        </select>
                                </div>
                            </div>
                            <div class="col-2">
                                    <button type="submit" class="btn btn-block btn-outline-primary " id="buat-gaji"><i class="nav-icon fa fa-send"></i></button>
                            </div>
                            </div>  <!-- /.row --> 
                            </div><!-- /.card-body -->
                            <!-- input manual -->

                            </form>
                            <!-- /.card-body -->

                            <!--/.col md-->
                            </div>
                    </div>
                <!-- input manual -->

          
            </div>
        </div>
    </section>
@stop

@section('script-bottom')
    @parent
    <script type="text/javascript">
        'use strict';
        let table;
        table = jQuery('#data1').DataTable({
            serverSide: true,
            processing: true,
            autoWidth: false,
            scrollX: true,
            // pageLength: 25,
            // lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            ajax: '{{ route('admin.' . $thisRoute . '.dataTable') }}',
            aaSorting: [ {!! isset($listAttribute['aaSorting']) ? $listAttribute['aaSorting'] : "[0,'desc']" !!}],
            columns: [
                    @foreach($passing as $fieldName => $fieldData)
                {data: '{{ $fieldName }}', title: "{{ __($fieldData['lang']) }}" <?php echo strlen($fieldData['custom']) > 0 ? $fieldData['custom'] : ''; ?> },
                @endforeach
            ],
            fnDrawCallback: function( oSettings ) {
                // $('a[data-rel^=lightcase]').lightcase();
            }
        });

        function actionData(link, method) {

            if(confirm('{{ __('general.ask_delete') }}')) {
                let linkSplit = link.split('/');
                let url = '';
                for(let i=3; i<linkSplit.length; i++) {
                    url += '/'+linkSplit[i];
                }

                jQuery.ajax({
                    url: url,
                    type: method,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(result) {

                    },
                    complete: function(){
                        table.ajax.reload();
                    }
                });
            }

        }

        function askingSubmit() {
           
           let  getText = prompt("Masukan Password Anda?");
            if (getText.toLocaleUpperCase() === 'SCS') {
                //$('#secret_approved').val('SCS');
                return true;
            }
            else {
                $.notify('harus mengisi password valid untuk menyetujui', 
                {type:"danger",align:"center", verticalAlign:"middle", zIndex:100000,  placement: 
                    {
                        from: "bottom",
                        align: "right"
                     },
                });
                return false;
            }
        }

        // function buatGaji(){
        //     let isiPeriode = {
        //         periode : $('#period-month').val(),
        //     };
          
        //     let link =  '{{ route('admin.karyawan_gaji.store') }}';
          
        //     let linkSplit = link.split('/');
            
        //     let url = '';
        //     for(let i=3; i<linkSplit.length; i++) {
        //         url += '/'+linkSplit[i];
        //     }

        //     console.log(url);
        
        //     $.ajax({

        //         url : url,
        //         type : 'POST',
        //         data: isiPeriode,
        //         headers: {
        //                 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        //         },
            
        //         success: function(result){

        //         },error: function(result){

        //         }
              
        //     });
        // }




    </script>
@stop
