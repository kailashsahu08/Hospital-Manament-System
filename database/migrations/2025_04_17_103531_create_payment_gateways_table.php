<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentGatewaysTable extends Migration
{
    public function up()
    {
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->string('payment_gateway_id')->primary();
            $table->string('name')->unique()->nullable();
            $table->string('status');
            $table->boolean('test_mode')->default(false);
            $table->text('secret_key')->nullable();
            $table->text('public_key')->nullable();
            $table->text('webhook_secret')->nullable();
            $table->timestamp('created_at', 3)->useCurrent();
            $table->timestamp('updated_at', 3)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_gateways');
    }
}

