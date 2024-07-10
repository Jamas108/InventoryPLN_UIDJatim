<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
        'status',
    ];

    /**
     * Mark the notification as read.
     */
    public function markAsRead()
    {
        $this->update(['status' => 'read']);
    }
}
