<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capsule extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
        'content'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
