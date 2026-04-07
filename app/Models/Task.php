<?php

namespace App\Models;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use MongoDB\Laravel\Eloquent\Model;

class Task extends Model
{

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'category_id',
        'user_id',
        'due_date',
        'completed_at',
        'tags'
    ];

    protected $casts = [
        'status' => TaskStatus::class,
        'priority' => TaskPriority::class,
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
