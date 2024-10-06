<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class received_capsule extends Model
{
    use HasFactory;

    protected $fillable = [
        
    ];
    
    public function user() {
        return $this->belongsToMany(User::class);
    }
}
