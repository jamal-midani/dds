<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    protected $fillable = [
        'name',
        'description',
        'requirements',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get all applicants for this position
     */
    public function applicants(): HasMany
    {
        return $this->hasMany(Applicant::class);
    }

    /**
     * Get active positions
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
