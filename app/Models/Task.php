<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\TaskChanged;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';
    protected $guarded = [];
    public $timestamps = true;

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        parent::booted();

        // Fire the event when a task is created, updated, or deleted
        static::created(function ($task) {
            event(new TaskChanged());
        });

        static::updated(function ($task) {
            event(new TaskChanged());
        });

        static::deleted(function ($task) {
            event(new TaskChanged());
        });
    }

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
}
