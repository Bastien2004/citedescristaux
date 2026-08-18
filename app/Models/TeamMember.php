<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class TeamMember extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id', 'team_id', 'discord_id', 'discord_tag', 'role', 'position', 'is_captain',
    ];

    protected $casts = [
        'is_captain' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (TeamMember $member) {
            if (! $member->id) {
                $member->id = (string) Str::uuid();
            }
        });
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
