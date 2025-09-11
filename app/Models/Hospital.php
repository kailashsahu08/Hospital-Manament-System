<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hospital extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'website',
        'license_number',
        'type',
        'total_beds',
        'available_beds',
        'description',
        'facilities',
        'logo',
        'latitude',
        'longitude',
        'is_active',
        'opening_time',
        'closing_time',
        'is_24_hours'
    ];

    protected $casts = [
        'facilities' => 'array',
        'is_active' => 'boolean',
        'is_24_hours' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8'
    ];

    /**
     * Get the doctors associated with the hospital.
     */
    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class);
    }

    /**
     * Get the departments associated with the hospital.
     */
    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }

    /**
     * Get the appointments associated with the hospital.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Scope to get active hospitals.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the full address.
     */
    public function getFullAddressAttribute()
    {
        return $this->address . ', ' . $this->city . ', ' . $this->state . ' - ' . $this->zip_code;
    }

    /**
     * Check if hospital is open at given time.
     */
    public function isOpenAt($time)
    {
        if ($this->is_24_hours) {
            return true;
        }

        $time = is_string($time) ? \Carbon\Carbon::parse($time)->format('H:i:s') : $time->format('H:i:s');
        
        return $time >= $this->opening_time && $time <= $this->closing_time;
    }

    /**
     * Update available beds count.
     */
    public function updateAvailableBeds($count)
    {
        $this->update(['available_beds' => $count]);
    }
}