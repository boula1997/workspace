<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';
    protected $guarded = [];
    public $translatedAttributes = ['title'];
    public $timestamps = true;

    // Define the project relationship
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    // Define the employee relationship
    public function employee()
    {
        return $this->belongsTo(Admin::class, 'employee_id');
    }

    // Accessor for the title attribute
    public function getTitleAttribute($value)
    {
        return trim($value);
    }
}
