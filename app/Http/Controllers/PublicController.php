<?php

namespace App\Http\Controllers;

use App\Services\PositionService;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    protected PositionService $positionService;

    public function __construct(PositionService $positionService)
    {
        $this->positionService = $positionService;
    }

    /**
     * Display list of available positions
     */
    public function index()
    {
        $positions = $this->positionService->getActivePositions();
        return view('public.positions.index', compact('positions'));
    }

    /**
     * Show application form for a specific position
     */
    public function showApplicationForm($id)
    {
        $position = \App\Models\Position::active()->findOrFail($id);
        return view('public.positions.apply', compact('position'));
    }
}
