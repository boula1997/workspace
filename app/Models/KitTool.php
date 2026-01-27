<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
class KitTool extends \App\Models\BaseModel
{
    use HasFactory;
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'content', 'project_id'
    ];


        public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}