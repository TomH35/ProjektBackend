<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['stage_id', 'name', 'start_time', 'end_time', 'speaker', 'link', 'description', 'image_path'];
}
