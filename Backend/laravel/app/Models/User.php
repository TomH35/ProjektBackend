<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['email'];

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_registrations')
                    ->withTimestamps();
    }
}

