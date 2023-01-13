<?php

namespace App\Http\Controllers\API;

use App\Codes\Models\Category;
use App\Http\Controllers\Controller;
use App\Codes\Logic\MonitoringSystemController;
use App\Codes\Models\CategorySetting;
use App\Codes\Models\CategorySettingTask;
use App\Codes\Models\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class insertReportController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    // public function getCategorySetting()
    // {
        //
    //     CategorySetting::all();
    //     CategorySettingTask::all();
        //
    //     $monitoringLogic = new MonitoringSystemController();
    //     $data = $monitoringLogic->getCategoryTree(Category::all()->toArray());
        //
    //     return response()->json([
    //         'success' => 1,
    //         'data' => $data
    //     ]);
    // }

        public function postTask(Request $request){
         
           $validator =  $this->request->validate([
                'category_id' => 'required',
                'category_setting_task_id' => 'required',
                'foto' => 'required',
                'comment' => 'required',
                
            ]);


            $getCategory = $this->request->get('category_id');
            $getCategorySettingTask = $this->request->get('category_setting_task_id');
            $getPhoto = $this->request->get('foto');
            $getComment = $this->request->get('comment');
        
       
            //if($request->hasfile('foto')){
            //    $request->file('foto')->move('task/',$request->file('foto')->getClientOriginalName());
            //    $Task->foto = $request->file('foto')->getClientOriginalName();
            //    $Task->save();
            //    }
    
            try{
                
                $Task = new Task();
                $Task->category_id = $getCategory;
                $Task->category_setting_task_id = $getCategorySettingTask;
                $Task->foto = $getPhoto;
                $Task->comment = $getComment;
                $Task->submit_by = 'Ivan'; //session()->get('member_name')
                $Task->submit_time = date('Y-m-d');
                $Task->save();
               
                return response()->json([
                         'message' => 'Data Has Been Inserted',
                         'data' => $Task
                     ]);
                
            }
            catch (QueryException $e){
                return response()->json([
                    'message' => 'Insert Failed'
                 
                ]);
            }
        }


        public function updateTask(Request $request, $id){
            $validator =  $this->request->validate([
                'category_id' => 'required',
                'category_setting_task_id' => 'required',
                'foto' => 'required',
                'comment' => 'required',
                
            ]);


            $getCategory = $this->request->get('category_id');
            $getCategorySettingTask = $this->request->get('category_setting_task_id');
            $getPhoto = $this->request->get('foto');
            $getComment = $this->request->get('comment');
            
            try{
                
                $Task = Task::findOrFail($id);
                $Task->update([
                    'category_id' => $getCategory,
                    'category_setting_task_id' => $getCategorySettingTask,
                    'foto' => $getPhoto,
                    'comment' => $getComment,
                    'submit_by' => 'Ivan', //session()->get('member_name')
                    'submit_time' => date('Y-m-d')
                ]);
               
             
                
               
                return response()->json([
                         'message' => 'Data Has Been Updated',
                         'data' => $Task
                     ]);
                
            }
            catch (QueryException $e){
                return response()->json([
                    'message' => 'Update Failed'
                 
                ]);
            }
            
        
        }



}