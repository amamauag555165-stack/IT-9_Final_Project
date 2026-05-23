<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'event_date',
        'start_time',
        'end_time',
        'location',
        'required_volunteers',
        'status',
        'approval_status',
        'created_by',
        'organization_id',
        'image'
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function volunteers()
    {
        return $this->belongsToMany(User::class, 'event_user');
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }
}
