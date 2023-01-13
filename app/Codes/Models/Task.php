<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'id';
    protected $fillable = [
        'category_id',
        'category_setting_task_id',
        'foto',
        'comment',
        'submit_time',
        'submit_by',
        'confirm_time',
        'confirm_by'
    ];
    public function getCategory()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function getCategorySettingTask(){
        return $this->belongsTo(CategorySettingTask::class, 'category_setting_task_id', 'id');
       
    }
   
 
    

}
