<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'poster_path',
        'event_date',
        'event_time',
        'location',
        'category',
        'type',
        'registration_link',
        'status',
        'created_by',
        'views_count'
    ];

    protected $casts = [
        'event_date' => 'date',
        'event_time' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    public function getFormattedEventDateAttribute()
    {
        return $this->event_date->format('d M Y');
    }

    public function getFormattedEventTimeAttribute()
    {
        return $this->event_time->format('H:i');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function participants()
    {
        return $this->hasMany(EventParticipant::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }
} 