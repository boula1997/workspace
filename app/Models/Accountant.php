<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Accountant extends \App\Models\BaseModel
{
    use HasFactory;
    use \App\Models\Concerns\Auditable;
    protected $table = 'accountants';
    protected $guarded = [];
    public $translatedAttributes = ['title'];
    public $timestamps = true;

    public function employee(){ return $this->belongsTo(Admin::class,'admin_id'); }
    
}
