<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Team extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'id', 'name', 'status', 'points',
        'captain_id', 'captain_tag', 'captain_avatar', 'note',
    ];

    protected static function booted(): void
    {
        static::creating(function (Team $team) {
            if (! $team->id) {
                $team->id = (string) Str::uuid();
            }
        });
    }

    public function members(): HasMany
    {
        return $this->hasMany(TeamMember::class)
            ->orderByRaw("CASE role WHEN 'TITULAIRE' THEN 0 ELSE 1 END, position");
    }
}
