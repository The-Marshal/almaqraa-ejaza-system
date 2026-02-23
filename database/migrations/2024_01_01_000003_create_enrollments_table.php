<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('admin_id')->nullable()->constrained('admin')->onDelete('set null');
            $table->string('requested_path_name')->nullable(); // القراءة أو الرواية المطلوبة
            $table->string('status')->default('new');
            $table->string('teacher_decision')->nullable();
            $table->enum('moshafaha', ['yes', 'no'])->default('no');
            $table->string('moshafaha_file')->nullable();
            $table->string('progress_checkpoint')->nullable();
            $table->timestamps();
        });
    }
    public function down() { Schema::dropIfExists('enrollments'); }
};