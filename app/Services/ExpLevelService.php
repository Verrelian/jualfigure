<?php

namespace App\Services;

class ExpLevelService
{
    public static function getLevel($exp)
    {
        $levels = [
            1 => 0,
            2 => 1000,
            3 => 3000,
            4 => 6000,
            5 => 10000,
        ];

        $currentLevel = 1;
        $nextLevelExp = null;

        foreach ($levels as $level => $requiredExp) {
            if ($exp >= $requiredExp) {
                $currentLevel = $level;
            } else {
                $nextLevelExp = $requiredExp;
                break;
            }
        }

        return [
            'level' => $currentLevel,
            'next_exp' => $nextLevelExp,
            'current_exp' => $exp,
            'exp_to_next' => $nextLevelExp ? $nextLevelExp - $exp : 0,
            'progress' => $nextLevelExp ? round($exp / $nextLevelExp * 100, 1) : 100
        ];
    }
}
