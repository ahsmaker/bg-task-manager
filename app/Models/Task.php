<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    const STATUS_PENDING     = 0;
    const STATUS_IN_PROGRESS = 1;
    const STATUS_COMPLETED   = 2;

    const PRIORITY_NORMAL = 0;
    const PRIORITY_HIGH   = 1;

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'status',
        'priority',
    ];

    protected $guarded = [
        'user_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($task) {
            $task->user_id = Auth::id();
        });
    }

    public static function getStatusOptions()
    {
        return [
            self::STATUS_PENDING     => 'Pending',
            self::STATUS_IN_PROGRESS => 'In Progress',
            self::STATUS_COMPLETED   => 'Completed',
        ];
    }

    public static function getPriorityOptions()
    {
        return [
            self::PRIORITY_NORMAL => 'Normal',
            self::PRIORITY_HIGH   => 'High',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
