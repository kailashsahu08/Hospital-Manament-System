<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'department_id',
        'appointment_date',
        'start_time',
        'end_time',
        'status', // Scheduled, Completed, Cancelled, No-show
        'type', // In-person, Virtual
        'reason',
        'notes',
        'is_follow_up',
        'previous_appointment_id'
    ];

    /**
     * Get the doctor associated with the appointment.
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Get the patient associated with the appointment.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the department associated with the appointment.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the payment associated with the appointment.
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}
