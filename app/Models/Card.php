<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = ['name', 'description', 'link', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}