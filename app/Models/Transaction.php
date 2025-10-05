<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'transaction_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'transaction_id',
        'booking_id',
        'transaction_reference',
        'amount',
        'payment_gateway',
        'receipt_url',
        'refund_reason',
        'created_at',
        'updated_at',
        'processed_by',
        'payment_gateway_id',
        'state_data',
        'status',
        'transaction_from',
        'transaction_response',
        'type_of_transaction',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class, 'transaction_id', 'transaction_id');
    }
}