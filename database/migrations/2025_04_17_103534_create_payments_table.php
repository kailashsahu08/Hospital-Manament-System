<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->string('payment_id')->primary();
            $table->string('discount_id')->nullable();
            $table->string('payment_gateway_id')->nullable();
            $table->string('status');
            $table->decimal('amount', 10, 2);
            $table->string('type_of_payment');
            $table->string('transaction_id')->unique();
            $table->text('payment_response')->nullable();
            $table->string('transaction_reference')->unique();
            $table->unsignedBigInteger('submitted_by')->nullable();
            $table->timestamp('created_at', 3)->useCurrent();
            $table->timestamp('updated_at', 3)->nullable();
            $table->unsignedBigInteger('appointments_id')->nullable();
            $table->text('note')->nullable();

            // Foreign Keys
            $table->foreign('payment_gateway_id')
                  ->references('payment_gateway_id')->on('payment_gateways')
                  ->onDelete('set null')->onUpdate('cascade');

            $table->foreign('transaction_id')
                  ->references('transaction_id')->on('transactions')
                  ->onDelete('restrict')->onUpdate('cascade');

            $table->foreign('submitted_by')
                  ->references('id')->on('users')
                  ->onDelete('set null')->onUpdate('cascade');

            $table->foreign('appointments_id')
                  ->references('id')->on('appointments')
                  ->onDelete('set null')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
