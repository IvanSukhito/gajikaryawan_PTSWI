<?php

namespace App\Http\Controllers\API;

use App\Codes\Models\Category;
use App\Http\Controllers\Controller;
use App\Codes\Models\CategorySetting;
use App\Codes\Models\CategorySettingTask;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getIndex()
    {
        return rand(0, 100);
    }

    public function getCategory()
    {
        $getParentId = $this->request->get('parent_id');
        if ($getParentId) {
            $getParentId = intval($getParentId);
        }
        else {
            $getParentId = 0;
        }

        $data = Category::where('parent_id', $getParentId)->get();

        return response()->json([
            'success' => 1,
            'data' => $data
        ]);
    }

    public function getCategoryTask(){
        $categoryTask = CategorySettingTask::find(1);
        return response()->json([
            'success' => 1,
            'data' => $categoryTask
        ]);
    }
    public function postCategory(){
        $getParent = $this->request->get('parent_id');
        $getName = $this->request->get('name');
    
        $data = Category::find($getParent);
        
        if($getParent == 0){
        $getTopId = 0;
        }
        elseif($data->parent_id > 0){
            $getTopId = $data->top_id;
        }else{
            $getTopId = $data->id; 
        }
        $getTop = $getTopId;
        
    
        $category = new category();
        $category->name = $getName;
        $category->parent_id = $getParent;
        $category->top_id = $getTop;
        $category->save();
        

        return response()->json([
            'message' => "success",
            'data' => $category  
         
        ]);
    }

    public function updateCategory(Request $request,$id){
        $getParent = $this->request->get('parent_id');
        $getName = $this->request->get('name');
    
        $data = Category::find($getParent);
        
        if($getParent == 0){
        $getTopId = 0;
        }
        elseif($data->parent_id > 0){
            $getTopId = $data->top_id;
        }else{
            $getTopId = $data->id; 
        }
        $getTop = $getTopId;
        
        $category = Category::findOrFail($id);
        $category->update([
            'parent_id' => $getParent,
            'top_id' => $getTop,
            'name' => $getName
        ]);
        
        return response()->json([
            'message' => "success update",
            'data' => $category  
         
        ]);
    }

    public function destroyCategory($id){
        $category = Category::find($id);
        $category->delete();
        return response()->json([
            'message' => 'Success Delete'
        ]);
    }
}
