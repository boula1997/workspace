<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'd_b_credential_id',
        'user_id',
        'is_active',
        'is_fixed',
        'search_count',
        'last_searched_at',
        'updated_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_fixed' => 'boolean',
        'last_searched_at' => 'datetime',
    ];

    /**
     * Get the credential that owns this search
     */
    public function credential()
    {
        return $this->belongsTo(Credential::class, 'd_b_credential_id');
    }


    /**
     * Scope active searches
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope fixed searches
     */
    public function scopeFixed($query)
    {
        return $query->where('is_fixed', true);
    }


}