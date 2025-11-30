<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Applicant extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'age',
        'education',
        'experience',
        'skills',
        'position_id',
        'cv_file',
        'status',
        'rating',
        'score',
        'gemini_summary',
    ];

    protected $casts = [
        'age' => 'integer',
        'rating' => 'integer',
        'score' => 'decimal:2',
    ];

    /**
     * Get the position that this applicant applied for
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * Get applicants by status
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Get applicants for a specific position
     */
    public function scopeForPosition($query, int $positionId)
    {
        return $query->where('position_id', $positionId);
    }
}
