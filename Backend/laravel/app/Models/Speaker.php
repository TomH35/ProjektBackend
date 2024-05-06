<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'surname',
        'image_path',
        'short_description',
        'long_description',
        'social_links',
        'admin_id',
    ];

    /**
     * Get the admin that owns the speaker.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
