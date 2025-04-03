<?php

/**
 * Convert hex color to rgba
 */
if (!function_exists('hex_to_rgba')) {
    function hex_to_rgba($hex, $opacity = 1) {
        $hex = str_replace('#', '', $hex ?? '');

        if (strlen($hex) == 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }

        $rgb = [
            hexdec(substr($hex, 0, 2)),
            hexdec(substr($hex, 2, 2)),
            hexdec(substr($hex, 4, 2))
        ];

        return 'rgba(' . implode(',', $rgb) . ',' . $opacity . ')';
    }
}

/**
 * Calculate calories from protein grams
 */
if (!function_exists('proteinCalories')) {
    function proteinCalories($grams) {
        return $grams * 4; // 4 calories per gram of protein
    }
}

/**
 * Calculate calories from carbohydrate grams
 */
if (!function_exists('carbsCalories')) {
    function carbsCalories($grams) {
        return $grams * 4; // 4 calories per gram of carbs
    }
}

/**
 * Calculate calories from fat grams
 */
if (!function_exists('fatCalories')) {
    function fatCalories($grams) {
        return $grams * 9; // 9 calories per gram of fat
    }
}

/**
 * Calculate percent daily value for calories
 */
if (!function_exists('caloriesDailyValue')) {
    function caloriesDailyValue($calories) {
        return round(($calories / 2000) * 100); // Based on 2000 calorie diet
    }
}

/**
 * Calculate percent daily value for protein
 */
if (!function_exists('proteinDailyValue')) {
    function proteinDailyValue($grams) {
        return round(($grams / 50) * 100); // Based on 50g daily value
    }
}

/**
 * Calculate percent daily value for carbohydrates
 */
if (!function_exists('carbsDailyValue')) {
    function carbsDailyValue($grams) {
        return round(($grams / 275) * 100); // Based on 275g daily value
    }
}

/**
 * Calculate percent daily value for fat
 */
if (!function_exists('fatDailyValue')) {
    function fatDailyValue($grams) {
        return round(($grams / 78) * 100); // Based on 78g daily value
    }
}

/**
 * Calculate percent daily value for fiber
 */
if (!function_exists('fiberDailyValue')) {
    function fiberDailyValue($grams) {
        return round(($grams / 28) * 100); // Based on 28g daily value
    }
}
