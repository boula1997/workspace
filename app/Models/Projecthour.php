<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projecthour extends Model
{
    use HasFactory;
    protected $table = 'project_hours';
    protected $guarded = [];
    public $timestamps = true;

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function employee()
    {
        return $this->belongsTo(Admin::class);
    }
}
