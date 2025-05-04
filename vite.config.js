import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/charts/foodMacroChart.js',
                'resources/js/charts/mealStatsChart.js',
                'resources/js/charts/userRegistrationChart.js',
                'resources/js/charts/macroNutrientChart.js',
                'resources/js/charts/adminMealStatsChart.js',
                'resources/js/admin/foods.js',
                'resources/js/admin/foodItems.js',
                'resources/js/admin/meals.js'
            ],
            refresh: true,
        }),
    ],
});
