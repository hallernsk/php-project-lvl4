<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'status_id', 'created_by_id', 'assigned_to_id'
    ];

    public function status()
    {
        // имеет статус
        // belongsTo определяется у модели, содержащей внешний ключ
        return $this->belongsTo(TaskStatus::class);
    }

    public function creator()
    {
        // создана пользователем
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function performer()
    {
        // поручена пользователю
        return $this->belongsTo(User::class, 'assigned_to_id');
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }
}
