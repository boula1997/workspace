<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminSession extends Model
{
    protected $fillable = [
        'admin_id',
        'jti',
        'device_name',
        'ip_address',
        'user_agent',
        'last_active_at',
        'revoked_at',
    ];

    protected $casts = [
        'last_active_at' => 'datetime',
        'revoked_at' => 'datetime',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
