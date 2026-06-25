<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DBCredential extends \App\Models\BaseModel
{
    use HasFactory;

    protected $guarded=[];

        public function project()
    {
        return $this->hasOne(Project::class, 'd_b_credential_id')
            ->withoutGlobalScopes();
    }
}
