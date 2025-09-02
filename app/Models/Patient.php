<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;

class Patient extends Model
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
        'blood_group',
        'allergies',
        'chronic_diseases',
        'emergency_contact_name',
        'emergency_contact_relationship',
        'emergency_contact_phone',
        'insurance_provider',
        'insurance_policy_number',
        'height',
        'weight',
        'profile_picture'
    ];

    /**
     * Get the user associated with the patient.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the appointments for the patient.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get the test reports for the patient.
     */
    public function testReports(): HasMany
    {
        return $this->hasMany(TestReport::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($patient) {
            $user = User::create([
                'name' => $patient->first_name . ' ' . $patient->last_name,
                'email' => $patient->email,
                'password' => Hash::make($patient->email),
            ]);

            $patient->user_id = $user->id;

            $patient->name = $user->name;
        });
    }
}
