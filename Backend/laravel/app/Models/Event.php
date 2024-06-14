<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'stage_id',
        'speaker_id',
        'name',
        'start_time',
        'end_time',
        'link',
        'description',
        'image_path'
    ];

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function speaker()
    {
        return $this->belongsTo(Speaker::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'event_registrations')
                    ->withTimestamps();
    }
}


