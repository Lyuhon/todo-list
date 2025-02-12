<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Task;

class User extends Authenticatable
{
    // Используем трейты для API токеов, фабрик и уведомлений
    use HasApiTokens, HasFactory, Notifiable;

    // Поля разрешённые для массового заполнения
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Скрытые поля
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Приведение типов и защита пароля
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Определение связи (один ко многим) с задачами
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}