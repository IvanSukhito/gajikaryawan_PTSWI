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
                    {{ Form::open(['route' => ['admin.' . $thisRoute . '.update', $data->{$masterId}], 'method' => 'PUT', 'files' => true, 'id'=>'form',
                    'role' => 'form', 'onsubmit' => 'return checkform()' ])  }}
                @else
                    {{ Form::open(['id'=>'form', 'role' => 'form'])  }}
                @endif

                <div class="card-body">
                    @include(env('ADMIN_TEMPLATE').'._component.generate_forms')
                </div>
                <div class="card-body" id="add_task_container">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="add_tasks_task">{{ __('general.task') }}</label>
                                {{ Form::text('add_tasks_task', old('add_tasks_task'), ['id' => 'add_tasks_task', 'class' => 'form-control', 'placeholder' => __('general.task')]) }}
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="form-group">
                                <label for="add_tasks_percentage">{{ __('general.percentage') }} (%)</label>
                                {{ Form::text('add_tasks_percentage', old('add_tasks_percentage'), ['id' => 'add_tasks_percentage', 'class' => 'form-control', 'placeholder' => '12.54']) }}
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="form-group">
                                <label for="add_tasks_date">{{ __('general.date') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend datepicker-trigger">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                    {{ Form::text('add_tasks_date', old('add_tasks_date'), ['id' => 'add_tasks_date', 'class' => 'form-control pull-right datepicker', 'placeholder' => __('general.date')]) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="button" id="add_tasks" onclick="addTask()" class="btn btn-info">{{ __('general.add_tasks') }}</button>
                    </div>
                </div>
                <div class="card-body" id="edit_task_container">
                    <div class="row">
                        <div class="col-12 col-md-5">
                            <div class="form-group">
                                <label for="edit_tasks_task">{{ __('general.task') }}</label>
                                {{ Form::text('edit_tasks_task', old('edit_tasks_task'), ['id' => 'edit_tasks_task', 'class' => 'form-control', 'placeholder' => __('general.task')]) }}
                            </div>
                        </div>
                        <div class="col-4 col-md-2">
                            <div class="form-group">
                                <label for="edit_tasks_percentage">{{ __('general.percentage') }} (%)</label>
                                {{ Form::text('edit_tasks_percentage', old('edit_tasks_percentage'), ['id' => 'edit_tasks_percentage', 'class' => 'form-control', 'placeholder' => '12.54']) }}
                            </div>
                        </div>
                        <div class="col-4 col-md-3">
                            <div class="form-group">
                                <label for="edit_tasks_date">{{ __('general.date') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend datepicker-trigger">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                    {{ Form::text('edit_tasks_date', old('edit_tasks_date'), ['id' => 'edit_tasks_date', 'class' => 'form-control pull-right datepicker', 'placeholder' => __('general.date')]) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-2">
                            <div class="form-group">
                                <label for="edit_tasks_order">{{ __('general.order') }}</label>
                                {{ Form::text('edit_tasks_order', old('edit_tasks_order'), ['id' => 'edit_tasks_order', 'class' => 'form-control', 'placeholder' => '1']) }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="button" id="edit_tasks" onclick="updateTask()" class="btn btn-info">{{ __('general.edit_tasks') }}</button>
                        <button type="button" id="cancel_tasks" onclick="cancelTask()" class="btn btn-warning">{{ __('general.cancel_tasks') }}</button>
                    </div>
                </div>      
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                            <tr>
                                <th>{{ __('general.task') }}</th>
                                <th>{{ __('general.date') }}</th>
                                <th>{{ __('general.percentage') }} (%)</th>
                                <th>{{ __('general.order') }}</th>
                                <th>{{ __('general.action') }}</th>
                            </tr>
                            </thead>
                            <tbody id="list-tasks">
                            @foreach($dataDetails as $index => $dataDetail)
                                <tr>
                                    <td id="label_task_{{ $index }}">{{ $dataDetail->name }}</td>
                                    <td id="label_date_{{ $index }}">{{ $dataDetail->target_finish }}</td>
                                    <td id="label_percentage_{{ $index }}">{{ $dataDetail->percentage }}%</td>
                                    <td id="label_order_{{ $index }}">{{ $dataDetail->order }}</td>
                                    <td>
                                        <input type="hidden" id="old_id_{{ $index }}" name="old_id[{{ $index }}]" value="{{ $dataDetail->id }}"/>
                                        <input type="hidden" id="task_{{ $index }}" name="task[{{ $index }}]" value="{{ $dataDetail->name }}"/>
                                        <input type="hidden" id="date_{{ $index }}" name="date[{{ $index }}]" value="{{ $dataDetail->target_finish }}"/>
                                        <input type="hidden" id="percentage_{{ $index }}" name="percentage[{{ $index }}]" value="{{ $dataDetail->percentage }}"/>
                                        <input type="hidden" id="order_{{ $index }}" name="order[{{ $index }}]" value="{{ $dataDetail->order }}"/>
                                        <button type="button" onclick="editTask(this)" data-id="{{ $index }}" class="mb-1 btn btn-primary btn-sm">{!! __('general.edit') !!}</button>
                                        <button type="button" onclick="removeTask(this)" data-id="{{ $index }}" class="mb-1 btn btn-danger btn-sm">{!! __('general.delete') !!}</button>
                                    </td>
                                <tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

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
    <script type="text/javascript">
        'use strict';

        let taskIndex = {{ count($dataDetails) }};
        let updateIndex = 0;
        var estimateDateStart = '{{$data->estimate_date_start}}';
        var estimateDateEnd = '{{$data->estimate_date_end}}';


        $(document).ready(function() {
            $('#add_task_container').show();
            $('#edit_task_container').hide();
        });

        function addTask() {

            let tasksTask = $('#add_tasks_task').val();
            let tasksPercentage = $('#add_tasks_percentage').val();
            let tasksDate = $('#add_tasks_date').val();
            let pass = 1;
            var estimateDateStart = '{{$data->estimate_date_start}}';
            var estimateDateEnd = '{{$data->estimate_date_end}}';

            if (tasksTask.length <= 0) {
                pass = 0;
                $.notify({
                    // options
                    message: '{!! __('general.error_data_empty_', ['field' => __('general.task')]) !!}'
                },{
                    // settings
                    type: 'danger',
                    placement: {
                        from: "bottom",
                        align: "right"
                    },
                });
            }
            else if (tasksPercentage.length <= 0) {
                pass = 0;
                $.notify({
                    // options
                    message: '{!! __('general.error_data_empty_', ['field' => __('general.percentage')]) !!}'
                },{
                    // settings
                    type: 'danger',
                    placement: {
                        from: "bottom",
                        align: "right"
                    },
                });
            }
        
          
           if(estimateDateStart && estimateDateEnd != null ){
            if (tasksDate  < estimateDateStart) {
                pass= 0;
                $.notify({
                    // options
                    message: '{!! __('general.error_estimate_date_start', ['field' => __('general.date')]) !!}'
                },{
                    // settings
                    type: 'danger',
                    placement: {
                        from: "bottom",
                        align: "right"
                    },
                });
            }
            else if (tasksDate  > estimateDateEnd) {
                pass= 0;
                $.notify({
                    // options
                    message: '{!! __('general.error_estimate_date_end', ['field' => __('general.date')]) !!}'
                },{
                    // settings
                    type: 'danger',
                    placement: {
                        from: "bottom",
                        align: "right"
                    },
                });
            }
          
           }
         
            if (pass === 1) {

                let newOrder = taskIndex + 1;

                $('#list-tasks').append('<tr>' +
                    '<td id="label_task_' + taskIndex + '">' + tasksTask + '</td>' +
                    '<td id="label_date_' + taskIndex + '">' + tasksDate + '</td>' +
                    '<td id="label_percentage_' + taskIndex + '">' + tasksPercentage + '%</td>' +
                    '<td id="label_order_' + taskIndex + '">' + newOrder + '</td>' +
                    '<td>' +
                    '<input type="hidden" id="task_' + taskIndex + '" name="task[' + taskIndex + ']" value="' + tasksTask + '"/>' +
                    '<input type="hidden" id="date_' + taskIndex + '" name="date[' + taskIndex + ']" value="' + tasksDate + '"/>' +
                    '<input type="hidden" id="percentage_' + taskIndex + '" name="percentage[' + taskIndex + ']" value="' + tasksPercentage + '"/>' +
                    '<input type="hidden" id="order_' + taskIndex + '" name="order[' + taskIndex + ']" value="' + newOrder + '"/>' +
                    '<button type="button" onclick="editTask(this)" data-id="' + taskIndex + '" class="mb-1 btn btn-primary btn-sm">{!! __('general.edit') !!}</button>' +
                    '<button type="button" onclick="removeTask(this)" data-id="' + taskIndex + '" class="mb-1 btn btn-danger btn-sm">{!! __('general.delete') !!}</button>' +
                    '</td>');

                clearTask();

                taskIndex++;

        
           }

        }

        function clearTask() {
            $('#add_tasks_task').val('');
            $('#edit_tasks_task').val('');
            $('#add_tasks_percentage').val('');
            $('#edit_tasks_percentage').val('');
            $('#add_tasks_date').val('');
            $('#edit_tasks_date').val('');
        }

        function editTask(curr) {
          
            clearTask();

            updateIndex = $(curr).data('id');
            
    
            $('#edit_tasks_task').val($('#task_' + updateIndex).val());
            $('#edit_tasks_percentage').val($('#percentage_' + updateIndex).val());
            $('#edit_tasks_date').val($('#date_' + updateIndex).val());
            $('#edit_tasks_order').val($('#order_' + updateIndex).val());

            $('#add_task_container').hide();
            $('#edit_task_container').show();
        }

        function cancelTask() {

            clearTask();

            $('#add_task_container').show();
            $('#edit_task_container').hide();

            return false;
        }

        function updateTask() {
            let tasksDate = $('#edit_tasks_date').val();
            let pass = 1;
           if(estimateDateStart && estimateDateEnd != null ){
            if (tasksDate  < estimateDateStart  ) {
               pass= 0; 
                $.notify({
                    // options
                    message: '{!! __('general.error_estimate_date_start', ['field' => __('general.date')]) !!}'
                },{
                    // settings
                    type: 'danger',
                    placement: {
                        from: "bottom",
                        align: "right"
                    },
                });
            }
            else if (tasksDate  > estimateDateEnd  ) {
                pass= 0;
                $.notify({
                    // options
                    message: '{!! __('general.error_estimate_date_end', ['field' => __('general.date')]) !!}'
                },{
                    // settings
                    type: 'danger',
                    placement: {
                        from: "bottom",
                        align: "right"
                    },
                });
            }
            }
           
           if(pass === 1){
            
            $('#task_' + updateIndex).val($('#edit_tasks_task').val());
            $('#percentage_' + updateIndex).val($('#edit_tasks_percentage').val());
            $('#date_' + updateIndex).val($('#edit_tasks_date').val());
            $('#order_' + updateIndex).val($('#edit_tasks_order').val());
            $('#label_task_' + updateIndex).html($('#edit_tasks_task').val());
            $('#label_date_' + updateIndex).html($('#edit_tasks_date').val());
            $('#label_percentage_' + updateIndex).html($('#edit_tasks_percentage').val());
            $('#label_order_' + updateIndex).html($('#edit_tasks_order').val());

            $('#add_task_container').show();
            $('#edit_task_container').hide();

            clearTask();
        }
            return false;
        }

        function removeTask(curr) {

            if (confirm("{!! __('general.ask_delete') !!}")) {
                $(curr).parent().parent().remove();
            }

            return false;
        }

        
        function checkform() {

            let pass = 0;
            
            var total = 0;
            for(let i=0; i<taskIndex; i++) {
               let percentage = $("#percentage_" + i).val(); 
               var dd = parseInt(percentage);
               total += dd;
             
               // console.log($("#percentage_" + i).val());
            }
                    
                // console.log(total);
            // Ini untuk  batalin
           if(total > 100){
               pass= 0;
               
               $.notify({
                // options
                message: '{!! __('general.error_percentage_more_100') !!}'
            },{
                // settings
                type: 'danger',
                placement: {
                    from: "bottom",
                    align: "right"
                },
            });

            return false;
           }
           
           //untuk next request
            if (pass === 1) {
                clearTask();
             
            }
    
           
            
        }



    </script>
@stop
