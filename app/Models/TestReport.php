<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'test_name',
        'test_date',
        'test_result',
        'result_interpretation',
        'normal_range',
        'performed_by',
        'report_file',
        'is_critical',
        'remarks',
        'follow_up_required',
        'follow_up_date'
    ];

    /**
     * Get the patient associated with the test report.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the doctor associated with the test report.
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
