<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'payment_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'payment_id',
        'discount_id',
        'payment_gateway_id',
        'status',
        'amount',
        'type_of_payment',
        'transaction_id',
        'payment_response',
        'transaction_reference',
        'submitted_by',
        'created_at',
        'updated_at',
        'attraction_id',
        'booking_id',
        'note',
    ];

    public function paymentGateway()
    {
        return $this->belongsTo(PaymentGateway::class, 'payment_gateway_id', 'payment_gateway_id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'transaction_id');
    }
}
