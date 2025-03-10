<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\TaskChanged;
use App\Scopes\DateFilterScope;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';
    protected $guarded = [];
    public $timestamps = true;



    /**
     * Define the project relationship.
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * Define the employee relationship.
     */
    public function employee()
    {
        return $this->belongsTo(Admin::class, 'employee_id');
    }

    /**
     * Mutator for the title attribute.
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = trim($value);
    }
    public function getCounterAttribute($value)
    {
        return $this->status != 0 ? 0 : $value;
    }
    

    protected static function booted()
    {
        static::addGlobalScope(new DateFilterScope);
    }
}
