<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'color',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function tasks(){
        return $this->hasMany(Task::class, 'category_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
