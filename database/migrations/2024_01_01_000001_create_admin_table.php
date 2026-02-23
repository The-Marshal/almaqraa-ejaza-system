<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('admin', function (Blueprint $table) {
            $table->id();
            $table->enum('level', ['admin', 'mod', 'teacher', 'user'])->default('user');
            $table->string('name');
            $table->enum('gender', ['M', 'F'])->default('M');
            $table->string('email')->unique();
            $table->enum('status', ['yes', 'no'])->default('no');
            $table->string('password');
            $table->timestamps();
        });
    }
    public function down() { Schema::dropIfExists('admin'); }
};