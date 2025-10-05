<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->string('transaction_id')->primary();
            $table->string('booking_id');
            $table->string('transaction_reference')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('payment_gateway')->nullable();
            $table->text('receipt_url')->nullable();
            $table->text('refund_reason')->nullable();
            $table->timestamp('created_at', 3)->useCurrent();
            $table->timestamp('updated_at', 3)->nullable();
            $table->string('processed_by')->nullable();
            $table->string('payment_gateway_id')->nullable();
            $table->json('state_data')->nullable(); // use ->jsonb() if supported, else ->json()
            $table->string('status');
            $table->string('transaction_from')->nullable();
            $table->json('transaction_response')->nullable();
            $table->string('type_of_transaction');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}