<?php

namespace App\Services;

use App\Models\Applicant;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected string $apiKey;
    protected string $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key', env('GEMINI_API_KEY'));
    }

    /**
     * Generate summary for an applicant
     */
    public function generateApplicantSummary(Applicant $applicant): ?string
    {
        if (empty($this->apiKey)) {
            Log::warning('Gemini API key not configured');
            return null;
        }

        try {
            $prompt = $this->buildSummaryPrompt($applicant);

            $response = Http::timeout(30)->post($this->apiUrl . '?key=' . $this->apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $summary = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

                if ($summary) {
                    Log::info('Gemini summary generated', ['applicant_id' => $applicant->id]);
                    return $summary;
                }
            }

            Log::error('Gemini API error', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Gemini API exception', [
                'message' => $e->getMessage(),
                'applicant_id' => $applicant->id
            ]);
            return null;
        }
    }

    /**
     * Get top 3 recommendations for a position
     */
    public function getTopRecommendations(array $applicants, int $positionId): array
    {
        if (empty($this->apiKey)) {
            Log::warning('Gemini API key not configured');
            return [];
        }

        if (count($applicants) < 3) {
            return array_slice($applicants, 0, 3);
        }

        try {
            $prompt = $this->buildRecommendationPrompt($applicants, $positionId);

            $response = Http::timeout(30)->post($this->apiUrl . '?key=' . $this->apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $recommendation = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

                if ($recommendation) {
                    // Parse recommendation to extract top 3 applicant IDs
                    $topIds = $this->parseRecommendationIds($recommendation, $applicants);

                    Log::info('Gemini recommendations generated', [
                        'position_id' => $positionId,
                        'top_ids' => $topIds
                    ]);

                    return $topIds;
                }
            }

            Log::error('Gemini API error for recommendations', [
                'status' => $response->status()
            ]);

            // Fallback: return top 3 by score
            return array_slice(array_column($applicants, 'id'), 0, 3);
        } catch (\Exception $e) {
            Log::error('Gemini API exception for recommendations', [
                'message' => $e->getMessage()
            ]);

            // Fallback: return top 3 by score
            return array_slice(array_column($applicants, 'id'), 0, 3);
        }
    }

    /**
     * Build prompt for applicant summary
     */
    protected function buildSummaryPrompt(Applicant $applicant): string
    {
        return "قم بكتابة ملخص احترافي باللغة العربية للمتقدم التالي:

الاسم: {$applicant->name}
العمر: {$applicant->age}
المؤهل العلمي: {$applicant->education}
الخبرات: {$applicant->experience}
المهارات: {$applicant->skills}
المنصب المتقدم له: {$applicant->position->name}

اكتب ملخصاً مختصراً (3-4 جمل) يلخص نقاط القوة والملاءمة للمنصب.";
    }

    /**
     * Build prompt for recommendations
     */
    protected function buildRecommendationPrompt(array $applicants, int $positionId): string
    {
        $applicantsInfo = "";
        foreach ($applicants as $index => $applicant) {
            $num = $index + 1;
            $applicantsInfo .= "\nالمتقدم #{$num} (ID: {$applicant['id']}):\n";
            $applicantsInfo .= "- الاسم: {$applicant['name']}\n";
            $applicantsInfo .= "- العمر: {$applicant['age']}\n";
            $applicantsInfo .= "- المؤهل: {$applicant['education']}\n";
            $applicantsInfo .= "- الخبرة: {$applicant['experience']}\n";
            $applicantsInfo .= "- المهارات: {$applicant['skills']}\n";
            $applicantsInfo .= "- النقاط: {$applicant['score']}\n";
        }

        return "قم بتحليل المتقدمين التاليين واختر أفضل 3 متقدمين للمنصب:

{$applicantsInfo}

أرجو إرجاع فقط أرقام الـ IDs للمتقدمين الثلاثة الأفضل (مفصولة بفواصل)، مع شرح مختصر لكل واحد.";
    }

    /**
     * Parse recommendation IDs from Gemini response
     */
    protected function parseRecommendationIds(string $recommendation, array $applicants): array
    {
        // Try to extract IDs from the response
        preg_match_all('/ID:\s*(\d+)/i', $recommendation, $matches);

        if (!empty($matches[1])) {
            return array_map('intval', array_slice($matches[1], 0, 3));
        }

        // Fallback: return top 3 by score
        usort($applicants, fn($a, $b) => $b->score <=> $a->score);
        return array_slice(array_column($applicants, 'id'), 0, 3);
    }
}
