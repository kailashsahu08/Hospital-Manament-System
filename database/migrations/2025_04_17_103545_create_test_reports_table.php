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
        Schema::create('test_reports', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('patient_id')->nullable();
            $table->foreign('patient_id')
                ->references('id')
                ->on('patients')
                ->onDelete('cascade');

            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->foreign('doctor_id')
                ->references('id')
                ->on('doctors')
                ->onDelete('cascade');

            $table->string('test_name')->nullable();
            $table->date('test_date')->nullable();
            $table->text('test_result')->nullable();
            $table->text('result_interpretation')->nullable();
            $table->string('normal_range')->nullable();
            $table->string('performed_by')->nullable();
            $table->string('report_file')->nullable();

            // Fields with default values remain unchanged
            $table->boolean('is_critical')->default(false);
            $table->text('remarks')->nullable();
            $table->boolean('follow_up_required')->default(false);

            $table->date('follow_up_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_reports');
    }
};
