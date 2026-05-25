<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Difference extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the database credential that owns this difference.
     */
    public function dbCredential()
    {
        return $this->belongsTo(DBCredential::class, 'd_b_credential_id');
    }
}