<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    protected $table = 'payment_gateways';
    protected $primaryKey = 'payment_gateway_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'payment_gateway_id',
        'name',
        'status',
        'test_mode',
        'secret_key',
        'public_key',
        'webhook_secret',
        'created_at',
        'updated_at',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class, 'payment_gateway_id', 'payment_gateway_id');
    }
}
