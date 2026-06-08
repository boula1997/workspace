<?php

namespace App\Models;

use App\Traits\MorphFile;
use App\Traits\MorphFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Carbon\Carbon;
use App\Models\Deal;

class Project extends \App\Models\BaseModel
{
    use HasFactory,MorphFiles,MorphFile;
    protected $table = 'projects';
    protected $guarded = [];
    public $timestamps = true;

   protected $casts = [
        'deadline' => 'datetime',
        'links' => 'array',
    ];
    
    protected $appends = ['deal'];

    protected static function booted()
{
    static::addGlobalScope('excludePersonal', function ($query) {
        $query->where('isPersonal', '!=', 1);
    });
}

    public function getDeadlineAttribute($value)
    {
        return $value ? Carbon::parse($value)->timezone('Africa/Cairo') : null;
    }

    public function getPayedAttribute(){
      return $this->cost-rest($this);
    }
    
    public function feeses() {
     return $this->hasMany(Fee::class);
    }
    public function tasks(){ return $this->hasMany(Task::class); }

    public function getImagesAttribute()
    {
        return  count($this->files)>0?$this->files:["default.jpg"];
    }
    
    public function getImageAttribute()
    {
        return  count($this->files)>0?$this->files[0]->url:["default.jpg"];
    }
    // public function getDealAttribute()
    // {
    //     return  $this->deal;
    // }

public function getStatusAttribute()
{
    $tasksWithStatus0 = $this->tasks()->where('status', 0)->exists();

    if (!$tasksWithStatus0 && rest($this) > 1) {
        return 2;
    } elseif (rest($this) > 0) {
        return 1;
    } else {
        return 0;
    }
}

    public function dailyWorks(){ return $this->hasMany(DailyWork::class); }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
    
    public function deals()
{
    return $this->hasMany(Deal::class, 'project_id');
}

public function getDealAttribute()
{
    // لو فيه أي deal مش paid
    $hasUnsettledDeal = $this->deals()
        ->where('isPaid', 0)
        ->exists();

    return $hasUnsettledDeal ? 0 : 1;
}


public function scopeFilterByStatus($query, $status)
{
    $restSql = 'cost - (SELECT COALESCE(SUM(amount), 0) FROM fees WHERE fees.project_id = projects.id AND amount > 0)';

    return $query->where(function ($q) use ($status, $restSql) {
        if ($status == 0) {
            $q->whereRaw("$restSql <= 0");
        } elseif ($status == 1) {
            $q->whereRaw("$restSql > 0")
              ->whereHas('tasks', fn($t) => $t->where('status', 0));
        } elseif ($status == 2) {
            $q->whereRaw("$restSql > 1")
              ->whereDoesntHave('tasks', fn($t) => $t->where('status', 0));
        }
    });
}


public function projectHours()
{
    return $this->hasMany(Projecthour::class);
}

public function getHoursAttribute()
{
    return $this->projectHours()->sum('hours_count');
}

public function getHoursEmployeeAttribute()
{
    return $this->projectHours()->where('employee_id', auth('api')->user()->id)->sum('hours_count');
}

}
