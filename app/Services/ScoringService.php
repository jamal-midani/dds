<?php

namespace App\Services;

use App\Models\Applicant;

class ScoringService
{
    // Scoring weights
    const EXPERIENCE_WEIGHT = 40;
    const EDUCATION_WEIGHT = 30;
    const SKILLS_WEIGHT = 20;
    const AGE_WEIGHT = 10;

    /**
     * Calculate total score for an applicant (0-100)
     */
    public function calculateScore(Applicant $applicant): float
    {
        $experienceScore = $this->calculateExperienceScore($applicant->experience);
        $educationScore = $this->calculateEducationScore($applicant->education);
        $skillsScore = $this->calculateSkillsScore($applicant->skills);
        $ageScore = $this->calculateAgeScore($applicant->age);

        $totalScore = (
            ($experienceScore * self::EXPERIENCE_WEIGHT / 100) +
            ($educationScore * self::EDUCATION_WEIGHT / 100) +
            ($skillsScore * self::SKILLS_WEIGHT / 100) +
            ($ageScore * self::AGE_WEIGHT / 100)
        );

        return round($totalScore, 2);
    }

    /**
     * Calculate experience score (0-100)
     * Based on years of experience mentioned in the text
     */
    protected function calculateExperienceScore(?string $experience): float
    {
        if (empty($experience)) {
            return 0;
        }

        // Extract years from experience text
        $years = $this->extractYears($experience);

        // Score based on years
        if ($years >= 10) {
            return 100;
        } elseif ($years >= 7) {
            return 85;
        } elseif ($years >= 5) {
            return 70;
        } elseif ($years >= 3) {
            return 55;
        } elseif ($years >= 1) {
            return 40;
        } else {
            return 20;
        }
    }

    /**
     * Calculate education score (0-100)
     */
    protected function calculateEducationScore(string $education): float
    {
        $education = strtolower($education);

        // Arabic and English education levels
        if (str_contains($education, 'دكتوراه') || str_contains($education, 'phd') || str_contains($education, 'doctorate')) {
            return 100;
        } elseif (str_contains($education, 'ماجستير') || str_contains($education, 'master')) {
            return 85;
        } elseif (str_contains($education, 'بكالوريوس') || str_contains($education, 'bachelor') || str_contains($education, 'بكالوريوس')) {
            return 70;
        } elseif (str_contains($education, 'دبلوم') || str_contains($education, 'diploma')) {
            return 50;
        } elseif (str_contains($education, 'ثانوي') || str_contains($education, 'high school')) {
            return 30;
        } else {
            return 20;
        }
    }

    /**
     * Calculate skills score (0-100)
     * Based on number of skills mentioned
     */
    protected function calculateSkillsScore(?string $skills): float
    {
        if (empty($skills)) {
            return 0;
        }

        // Count skills (assuming comma or newline separated)
        $skillList = preg_split('/[,\n\r]+/', $skills);
        $skillCount = count(array_filter(array_map('trim', $skillList)));

        // Score based on number of skills
        if ($skillCount >= 10) {
            return 100;
        } elseif ($skillCount >= 7) {
            return 85;
        } elseif ($skillCount >= 5) {
            return 70;
        } elseif ($skillCount >= 3) {
            return 55;
        } elseif ($skillCount >= 1) {
            return 40;
        } else {
            return 0;
        }
    }

    /**
     * Calculate age score (0-100)
     * Optimal age range: 30-50
     */
    protected function calculateAgeScore(int $age): float
    {
        if ($age >= 30 && $age <= 50) {
            return 100; // Optimal age range
        } elseif ($age >= 25 && $age < 30) {
            return 80;
        } elseif ($age > 50 && $age <= 60) {
            return 70;
        } elseif ($age >= 20 && $age < 25) {
            return 60;
        } elseif ($age > 60) {
            return 40;
        } else {
            return 30;
        }
    }

    /**
     * Extract years of experience from text
     */
    protected function extractYears(string $text): int
    {
        // Look for patterns like "5 years", "5 سنوات", etc.
        $patterns = [
            '/(\d+)\s*(?:years?|سنوات?|سنة)/i',
            '/(\d+)\s*(?:year|سنة)/i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                return (int) $matches[1];
            }
        }

        // If no pattern found, estimate based on text length and keywords
        $text = strtolower($text);
        if (str_contains($text, 'senior') || str_contains($text, 'كبير')) {
            return 7;
        } elseif (str_contains($text, 'experienced') || str_contains($text, 'خبرة')) {
            return 5;
        } elseif (str_contains($text, 'junior') || str_contains($text, 'مبتدئ')) {
            return 2;
        }

        return 0;
    }
}
