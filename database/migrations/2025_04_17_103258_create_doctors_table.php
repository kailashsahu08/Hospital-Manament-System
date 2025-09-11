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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->unsignedBigInteger('hospital_id')->nullable();
            $table->foreign('hospital_id')
                ->references('id')
                ->on('hospitals')
                ->onDelete('cascade');
            
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email');
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('specialization')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onDelete('cascade');
            $table->string('license_number')->unique()->nullable();
            $table->integer('experience_years')->nullable();
            $table->decimal('consultation_fee', 10, 2)->nullable();
            $table->json('availability_schedule')->nullable();
            $table->string('profile_picture')->nullable();
            $table->text('bio')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
