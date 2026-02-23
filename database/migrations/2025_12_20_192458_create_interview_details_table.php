<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('interview_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->constrained('enrollments')->onDelete('cascade');

            // أسئلة التجويد الخمسة
            $table->text('q1_answer')->nullable();
            $table->text('q2_answer')->nullable();
            $table->text('q3_answer')->nullable();
            $table->text('q4_answer')->nullable();
            $table->text('q5_answer')->nullable();

            // مستويات التقييم
            $table->enum('theory_level', ['ممتاز', 'جيد', 'ضعيف']);
            $table->enum('recitation_level', ['ممتاز', 'جيد', 'ضعيف']);
            $table->enum('hifz_level', ['ممتاز', 'جيد', 'ضعيف']);

            // القرار والتواريخ
            $table->enum('decision', ['qualified', 'refer_to_teacher', 'review_theory', 'not_qualified']);
            $table->date('interview_date');
            $table->string('sheikh_1');
            $table->string('sheikh_2')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interview_details');
    }
};
