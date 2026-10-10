<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Setting extends \App\Models\BaseModel implements TranslatableContract
{

    use HasFactory, Translatable;
    protected $table = 'settings';
    protected $guarded = [];
    public $translatedAttributes = ['title', 'subtitle', 'description','copyright'];
    public $timestamps = true;


    public function getLogoAttribute($val)
    {
        return $this->assetOrNull($val);
    }
    public function getTabAttribute($val)
    {
        return $this->assetOrNull($val);
    }
    public function getwhiteLogoAttribute($val)
    {
        return $this->assetOrNull($val);
    }

    // The old fallback (settings()->logo) re-entered this same accessor and recursed forever
    // whenever file_exists() missed, e.g. when not running from public/.
    private function assetOrNull($val)
    {
        return $val ? asset($val) : null;
    }
}
