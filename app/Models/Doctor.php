<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'name',
        'phone',
        'address',
        'city',
        'state',
        'zip_code',
        'date_of_birth',
        'gender',
        'specialization',
        'department_id',
        'license_number',
        'experience_years',
        'consultation_fee',
        'availability_start_time',
        'availability_end_time',
        'profile_picture',
        'bio'
    ];

    /**
     * Get the user associated with the doctor.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the department associated with the doctor.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the appointments for the doctor.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
