<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Game extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Automatically generate slug from name before saving
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($game) {
            $game->slug = Str::slug($game->name);
        });

        static::updating(function ($game) {
            if ($game->isDirty('name')) {
                $game->slug = Str::slug($game->name);
            }
        });
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
} 