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
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique()->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code')->nullable();
            $table->string('country')->default('India');
            $table->string('website')->nullable();
            $table->string('license_number')->unique()->nullable();
            $table->enum('type', ['government', 'private', 'trust', 'corporate'])->default('private');
            $table->integer('total_beds')->nullable();
            $table->integer('available_beds')->nullable();
            $table->text('description')->nullable();
            $table->json('facilities')->nullable(); // Store array of facilities
            $table->string('logo')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->boolean('is_active')->default(true);
            $table->time('opening_time')->default('00:00:00');
            $table->time('closing_time')->default('23:59:59');
            $table->boolean('is_24_hours')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospitals');
    }
};