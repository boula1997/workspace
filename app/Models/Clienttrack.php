<?php

namespace App\Models;

use App\Traits\MorphFile;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Clienttrack as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\MorphOne;
class Clienttrack extends Model
{
    use HasApiTokens, HasFactory, Notifiable,MorphFile;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'action',
        'project_id',
    ];

    public function project(){ return $this->belongsTo(Project::class,'project_id'); }





}
