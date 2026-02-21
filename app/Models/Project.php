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
    ];
    
    protected $appends = ['deal'];

    public function getDeadlineAttribute($value)
    {
        return Carbon::parse($value)
            ->timezone('Africa/Cairo')
            ->format('Y-m-d H:i:s'); // or any format you prefer
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
}
