<?php

namespace App\Services;

use App\Models\Position;
use Illuminate\Support\Facades\Log;

class PositionService
{
    /**
     * Get all active positions
     */
    public function getActivePositions()
    {
        return Position::active()->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get all positions (for admin)
     */
    public function getAllPositions()
    {
        return Position::orderBy('created_at', 'desc')->get();
    }

    /**
     * Create a new position
     */
    public function createPosition(array $data): Position
    {
        $position = Position::create($data);
        Log::info('Position created', ['position_id' => $position->id, 'name' => $position->name]);
        return $position;
    }

    /**
     * Update a position
     */
    public function updatePosition(Position $position, array $data): Position
    {
        $position->update($data);
        Log::info('Position updated', ['position_id' => $position->id]);
        return $position;
    }

    /**
     * Delete a position
     */
    public function deletePosition(Position $position): bool
    {
        $positionId = $position->id;
        $positionName = $position->name;
        $deleted = $position->delete();

        if ($deleted) {
            Log::info('Position deleted', ['position_id' => $positionId, 'name' => $positionName]);
        }

        return $deleted;
    }

    /**
     * Toggle position status
     */
    public function toggleStatus(Position $position): Position
    {
        $position->status = !$position->status;
        $position->save();
        Log::info('Position status toggled', ['position_id' => $position->id, 'status' => $position->status]);
        return $position;
    }
}
