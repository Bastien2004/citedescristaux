<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Admin extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id', 'discord_id', 'label', 'added_by', 'created_at',
    ];

    protected static function booted(): void
    {
        static::creating(function (Admin $admin) {
            if (! $admin->id) {
                $admin->id = (string) Str::uuid();
            }
            if (! $admin->created_at) {
                $admin->created_at = now();
            }
        });
    }
}
