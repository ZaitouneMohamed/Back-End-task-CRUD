<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'status',
        'date',
    ];

    public function scopeFilterWithOwnership($query, $filters)
    {
        $query->when($filters['status'], function ($query, $status) {
            $query->where('status', $status);
        })
            ->with("user")
            ->get()
            ->transform(function ($task) {
                $task['is_owner'] = $task->user_id === auth()->id();
                return $task;
            });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
