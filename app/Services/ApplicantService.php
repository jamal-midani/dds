<?php

namespace App\Services;

use App\Models\Applicant;
use App\Models\Position;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ApplicantService
{
    protected ScoringService $scoringService;
    protected GeminiService $geminiService;

    public function __construct(ScoringService $scoringService, GeminiService $geminiService)
    {
        $this->scoringService = $scoringService;
        $this->geminiService = $geminiService;
    }

    /**
     * Create a new applicant
     */
    public function createApplicant(array $data, ?UploadedFile $cvFile = null): Applicant
    {
        // Handle CV file upload
        if ($cvFile) {
            $data['cv_file'] = $this->storeCvFile($cvFile);
        }

        $applicant = Applicant::create($data);

        // Calculate and save score
        $score = $this->scoringService->calculateScore($applicant);
        $applicant->update(['score' => $score]);

        // Generate Gemini summary (async - don't block)
        try {
            $summary = $this->geminiService->generateApplicantSummary($applicant);
            if ($summary) {
                $applicant->update(['gemini_summary' => $summary]);
            }
        } catch (\Exception $e) {
            Log::warning('Failed to generate Gemini summary', [
                'applicant_id' => $applicant->id,
                'error' => $e->getMessage()
            ]);
        }

        Log::info('Applicant created', [
            'applicant_id' => $applicant->id,
            'name' => $applicant->name,
            'position_id' => $applicant->position_id,
            'score' => $score
        ]);

        return $applicant;
    }

    /**
     * Update an applicant
     */
    public function updateApplicant(Applicant $applicant, array $data, ?UploadedFile $cvFile = null): Applicant
    {
        // Handle CV file upload if provided
        if ($cvFile) {
            // Delete old CV if exists
            if ($applicant->cv_file) {
                Storage::disk('public')->delete($applicant->cv_file);
            }
            $data['cv_file'] = $this->storeCvFile($cvFile);
        }

        $applicant->update($data);

        // Recalculate score if relevant fields changed
        if (isset($data['experience']) || isset($data['education']) || isset($data['age']) || isset($data['skills'])) {
            $score = $this->scoringService->calculateScore($applicant);
            $applicant->update(['score' => $score]);
        }

        Log::info('Applicant updated', ['applicant_id' => $applicant->id]);
        return $applicant;
    }

    /**
     * Delete an applicant
     */
    public function deleteApplicant(Applicant $applicant): bool
    {
        // Delete CV file if exists
        if ($applicant->cv_file) {
            Storage::disk('public')->delete($applicant->cv_file);
        }

        $applicantId = $applicant->id;
        $deleted = $applicant->delete();

        if ($deleted) {
            Log::info('Applicant deleted', ['applicant_id' => $applicantId]);
        }

        return $deleted;
    }

    /**
     * Store CV file
     */
    protected function storeCvFile(UploadedFile $file): string
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs('cvs', $filename, 'public');
    }

    /**
     * Get applicants for a position
     */
    public function getApplicantsForPosition(int $positionId, array $filters = [])
    {
        $query = Applicant::forPosition($positionId)->with('position');

        // Apply filters
        if (isset($filters['status'])) {
            $query->status($filters['status']);
        }

        if (isset($filters['min_score'])) {
            $query->where('score', '>=', $filters['min_score']);
        }

        if (isset($filters['min_rating'])) {
            $query->where('rating', '>=', $filters['min_rating']);
        }

        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('education', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortBy = $filters['sort_by'] ?? 'score';
        $sortOrder = $filters['sort_order'] ?? 'desc';

        return $query->orderBy($sortBy, $sortOrder)->get();
    }

    /**
     * Get top applicants for a position
     */
    public function getTopApplicants(int $positionId, int $limit = 3)
    {
        return Applicant::forPosition($positionId)
            ->whereNotNull('score')
            ->orderBy('score', 'desc')
            ->limit($limit)
            ->get();
    }
}
