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
        'availability_start_time',
        'availability_end_time',
        'profile_picture',
        'bio',
        'is_verified'
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
