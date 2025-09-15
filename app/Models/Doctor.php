<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'hospital_id',
        'first_name',
        'last_name',
        'name',
        'phone',
        'email',
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
        'availability_schedule',
        'profile_picture',
        'bio',
        'is_verified',
        'is_available',
    ];

    protected $casts = [
        'availability_schedule' => 'array', // ✅ JSON casting
        'is_verified' => 'boolean',
        'is_available' => 'boolean',
        'date_of_birth' => 'date',
        'consultation_fee' => 'decimal:2',
    ];

    /**
     * Get the user associated with the doctor.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the hospital associated with the doctor.
     */
    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class);
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($doctor) {
            $fullName = trim(($doctor->first_name ?? '') . ' ' . ($doctor->last_name ?? ''));

            if (empty($fullName)) {
                $fullName = $doctor->name ?? 'Unknown Doctor';
            }

            $user = User::create([
                'name' => $fullName,
                'email' => $doctor->email,
                'password' => Hash::make($doctor->email),
            ]);
            $user->assignRole('doctor');

            $doctor->user_id = $user->id;
            $doctor->name = $user->name;
        });
    }
}
