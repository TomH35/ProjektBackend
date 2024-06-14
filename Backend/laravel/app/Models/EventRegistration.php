<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EventRegistration extends Pivot
{
    use HasFactory;

    protected $table = 'event_registrations';

    protected $fillable = ['user_id', 'event_id'];
}
