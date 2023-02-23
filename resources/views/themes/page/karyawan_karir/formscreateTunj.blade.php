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
                    <div class="form-group">
                        <label for="karyawan">{{ __('general.karyawan') }} *</label>
                        {{ Form::select('karyawan', $datakaryawan, old('karyawan'), ['id' => 'karyawan', 'class' => 'form-control  input-lg select2']) }}
                    </div>
                   
                    <div class="form-group">
                        <label for="salary">{{ __('general.salary') }} *</label>
                        {{ Form::select('salary', $datasalary, old('salary'), ['id' => 'salary', 'class' => 'form-control  input-lg select2']) }}
                    </div>
                    <div class="form-group">
                        <label for="salary">{{ __('general.tunjangan_jabatan') }} *</label>
                        {{ Form::select('tunjangan_jabatan', $datatunj_jabatan, old('tunjangan_jabatan'), ['id' => 'tunjangan_jabatan', 'class' => 'form-control  input-lg select2']) }}
                    </div>
                  
            </div>
            

                <div class="card-body overflow">
                <div id="formTunjangan"></div>
                             
                </div>

                <!-- /.card-body -->

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
        
        let isiLoopingSalary = JSON.parse('{!! $listsalary !!}');
        let isiLoopingTunj = JSON.parse('{!! json_encode($listtunj) !!}');

        // console.log(isiLoopingTunj[410]);
     
       
        $(document).ready(function() {

            
            $('#karyawan').on('change', function() {
                var html = '<table class="table table-tunjtetap table-bordered table-striped">'+
                       '<thead>'+
                        '<tr>'+
                        '<th width="60%" colspan="5">Testing Dulu</th>'+
                        '<th width="15%" class="text-center">Nilai</th>'+
                        '<th width="10%" class="text-center">Satuan</th>'+
                        '<th width="15%" class="text-center">Status</th>'+
                        '</tr>'+
                        '</thead>'+
                        '<tbody>';
                        html += '<tr class="all-row tunjtetap-1 jen-0" style="">'+
                        '<td colspan="5">Gaji Pokok</td>'+
                        '<td width="15%">&nbsp;</td>'+
                        '<td width="10%" class="text-center"></td>'+
                        '<td width="15%" class="text-center"></td>'+
                        '</tr>';

                        html += render_table_tunjangan();
                        html += render_table_bpjs();
                        html +='</tbody></table>';

                $('#formTunjangan').html(html);     
            });

            $('#salary').on('change', function() {
                $('#karyawan').change();
            });

            $('#tunjangan_jabatan').on('change', function() {
                $('#karyawan').change();      
            });
            function render_table_tunjangan(){
                const arrTunjTetap = ['basic_salary','tunj_jabatan'];
                var html =  '<tr class="all-row tunjtetap-1 tunjtetap-2 jen-0" style=""><td width="1%">&nbsp;</td>'+
                                '<td colspan="4"><b>1.Tunjangan Upah Tetap</b></td>'+
                                '<td width="15%">&nbsp;</td>'+
                                '<td width="10%" class="text-center"></td>'+
                                '<td width="15%" class="text-center"></td>'+
                                '</tr>';
                const isiarrTunjTetap = [];
                 let kodegapok= $('#salary').val();
                 let tunjJabatan = $('#tunjangan_jabatan').val();
                 isiarrTunjTetap[0] = isiLoopingSalary[kodegapok-1].tunjangan_kerajinan;
                //  isiarrTunjTetap[0] = isiLoopingSalary[kodegapok];
                 isiarrTunjTetap[1] = isiLoopingTunj[tunjJabatan];
                 //isiarrTunjTetap[1] = isiLoopingTunj[tunjJabatan-1].tunjangan_jabatan;
        
                //  console.log(kodegapok);
                //  console.log(tunjJabatan);
                 console.log(isiarrTunjTetap);
                // console.log($('#karyawan').val());
           
                for (let i = 0; i<arrTunjTetap.length; i++){
                    html += '<tr class="all-row tunjtetap-1 tunjtetap-2 tunjtetap-3 jen-4" style="">'+
                        '<td width="1%">&nbsp;</td><td width="1%">&nbsp;</td>'+
                        '<td colspan="3">'+arrTunjTetap[i]+'</td>'+
                        '<td width="15%" class="text-center"><input type="text" name="'+arrTunjTetap[i]+'" class="form-control setMoney" value="'+isiarrTunjTetap[i]+'" readonly></td>'+
                        '<td width="10%" class="text-center">Decimal</td>'+
                        '<td width="15%" class="text-center">Upah Tetap</td>'+
                        '</tr>';
                }
               
                //upah Tak Tetap 
                html += '<tr class="all-row tunjtetap-1 tunjtetap-2 jen-0" style=""><td width="1%">&nbsp;</td>'+
                                '<td colspan="4"><b>2.Tunjangan lain - lain</b></td>'+
                                '<td width="15%">&nbsp;</td>'+
                                '<td width="10%" class="text-center"></td>'+
                                '<td width="15%" class="text-center"></td>'+
                                '</tr>';

                const arrTunjLain = ['tunj_kerajinan','tunj_shift','tunj_kehadiran','tunj_transport','tunj_bonus_produksi'];
                const isiarrTunjLain = [];
                isiarrTunjLain[0] = isiLoopingSalary[kodegapok-1].tunjangan_kerajinan;
                isiarrTunjLain[1] = isiLoopingSalary[kodegapok-1].tunjangan_shift;
                isiarrTunjLain[2] = isiLoopingSalary[kodegapok-1].tunjangan_kehadiran;
                isiarrTunjLain[3] = isiLoopingSalary[kodegapok-1].slt_day;
                isiarrTunjLain[4] = isiLoopingSalary[kodegapok-1].bonus_produksi;
                
                for (let j = 0; j<arrTunjLain.length; j++){
                    html += '<tr class="all-row tunjtetap-1 tunjtetap-2 tunjtetap-3 jen-4" style="">'+
                        '<td width="1%">&nbsp;</td><td width="1%">&nbsp;</td>'+
                        '<td colspan="3">'+arrTunjLain[j]+'</td>'+
                        '<td width="15%" class="text-center"><input type="text" name="'+arrTunjLain[j]+'" class="form-control setMoney" value="'+isiarrTunjLain[j]+'" ></td>'+
                        '<td width="10%" class="text-center">Decimal</td>'+
                        '<td width="15%" class="text-center">Upah Tetap</td>'+
                        '</tr>';

                }
            
                return html ;

            };


            function render_table_bpjs(){
                var html = '<tr class="all-row tunjtetap-1 jen-0" style="">'+
                        '<td colspan="5">BPJS</td>'+
                        '<td width="15%">&nbsp;</td>'+
                        '<td width="10%" class="text-center"></td>'+
                        '<td width="15%" class="text-center"></td>'+
                        '</tr>';
                    html += '<tr class="all-row tunjtetap-1 tunjtetap-2 jen-0" style=""><td width="1%">&nbsp;</td>'+
                                '<td colspan="4"><b>1.Dibayarkan Oleh Perusahaan</b></td>'+
                                '<td width="15%">&nbsp;</td>'+
                                '<td width="10%" class="text-center"></td>'+
                                '<td width="15%" class="text-center"></td>'+
                                '</tr>';

                    //isi 1        
                    html += '<tr class="all-row tunjtetap-1 tunjtetap-2 jen-0" style=""><td width="1%">&nbsp;</td>'+
                    '<td colspan="4"><b>2.Dibayarkan Oleh Karyawan</b></td>'+
                    '<td width="15%">&nbsp;</td>'+
                    '<td width="10%" class="text-center"></td>'+
                    '<td width="15%" class="text-center"></td>'+
                    '</tr>';     
                    //isi function 2       
                return html;
            };

      

        });
     

    </script>
@stop


