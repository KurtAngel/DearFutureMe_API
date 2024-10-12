<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivedCapsule extends Model
{
    use HasFactory;

    protected $table = 'receivedcapsules';
    protected $fillable = [
        'title',
        'message',
        'content',
        'receiver_email',
        'scheduled_open_at'
    ];
    
    public function user() {
        return $this->belongsTo(User::class);
    }
}
