<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'patient_id',
        'amount',
        'payment_date',
        'payment_method', // Credit Card, Cash, Insurance, etc.
        'transaction_id',
        'status', // Pending, Completed, Failed, Refunded
        'invoice_number',
        'discount',
        'tax',
        'total_amount',
        'is_insured',
        'insurance_coverage_amount',
        'patient_responsibility',
        'notes'
    ];

    /**
     * Get the appointment associated with the payment.
     */
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Get the patient associated with the payment.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
