<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Создаётся таблица tasks для хранения задач
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            // Создание ключа 'id'
            $table->id();

            // Создание столбца 'user_id' для связи задачи с пользователем
            // 'constrained()' автоматически привязывает внешний ключ к таблице 'users'
            // 'onDelete('cascade')' если пользователь удалится, то и задачи тоже
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Столбец 'title' для хранения названия задачи
            $table->string('title');

            // Столбец 'description' для хранения описания, но может быть пустым (nullable)
            $table->text('description')->nullable();

            // Столбец 'is_completed' хранит статус выполнения задачи (false по умолчанию)
            $table->boolean('is_completed')->default(false);

            // Автоматическое создание столбцов 'created_at' и 'updated_at'
            $table->timestamps();
        });
    }

    // Удаляется таблица tasks
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};