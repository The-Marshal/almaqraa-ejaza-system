<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->integer('country'); // مخزن كـ ID يربط بجدول الدول
            $table->integer('nationality');
            $table->enum('gender', ['male', 'female']);
            $table->string('password');
            $table->timestamps();
        });
    }
    public function down() { Schema::dropIfExists('users'); }
};