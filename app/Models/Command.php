<?php
// app/Models/Command.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Command extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'd_b_credential_id',
        'title',
        'content',
        'database_name',
        'is_fixed',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_fixed' => 'boolean',
    ];

    /**
     * Get the credential that owns this command.
     */
    public function credential(): BelongsTo
    {
        return $this->belongsTo(DBCredential::class, 'd_b_credential_id');
    }
}