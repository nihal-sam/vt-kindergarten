<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->string('child_name');
            $table->date('dob');
            $table->enum('gender', ['Male', 'Female']);
            $table->string('program');
            $table->string('parent_name');
            $table->string('relation');
            $table->string('phone', 20);
            $table->string('email')->nullable();
            $table->text('address');
            $table->string('previous_school')->nullable();
            $table->text('message')->nullable();
            $table->enum('status', ['pending', 'reviewed', 'approved', 'rejected'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};
