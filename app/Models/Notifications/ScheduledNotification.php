<?php

namespace App\Models\Notifications;

use Illuminate\Database\Eloquent\Model;

class ScheduledNotification extends Model
{
    protected $table = 'scheduled_notifications';

    protected $fillable = [
        'title',
        'content',
        'image',
        'type',
        'month',
        'week',
        'day',
        'time',
        'status'
    ];

    protected $casts = [
        'month' => 'integer',
        'week' => 'integer',
        'day' => 'integer',
        'time' => 'datetime',
        'status' => 'string'
    ];

    protected $dates = [
        'deleted_at'
    ];
}
