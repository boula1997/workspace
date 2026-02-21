<?php

namespace App\Models;

use App\Traits\MorphFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends \App\Models\BaseModel
{
    use HasFactory, MorphFile;

    protected $table = 'categories';
    protected $guarded = [];
    public $timestamps = true;

    /*
    |--------------------------------------------------------------------------
    | Image Accessor
    |--------------------------------------------------------------------------
    */
    public function getImageAttribute()
    {
        return $this->file
            ? asset($this->file->url)
            : settings()->logo;
    }
    public function getPlaceholderAttribute()
    {
        return json_encode($this->search_keys);
    }

    /*
    |--------------------------------------------------------------------------
    | Convert search_keys string → array
    |--------------------------------------------------------------------------
    | Example in DB:
    | "title,project.title,status"
    |--------------------------------------------------------------------------
    */
    public function getSearchKeysAttribute($value)
    {
        return $value
            ? array_map('trim', explode(',', $value))
            : [];
    }

    /*
    |--------------------------------------------------------------------------
    | Convert filter_keys string → array
    |--------------------------------------------------------------------------
    */
    public function getFilterKeysAttribute($value)
    {
        return $value
            ? array_map('trim', explode(',', $value))
            : [];
    }

    /*
    |--------------------------------------------------------------------------
    | Get Config Class (with fallback)
    |--------------------------------------------------------------------------
    */
    public function getResolvedConfigClassAttribute()
    {
        return $this->config_class && class_exists($this->config_class)
            ? $this->config_class
            : \App\CategoryConfigs\BaseCategoryConfig::class;
    }
}