import {Chart, PieController, ArcElement, Tooltip, Legend} from 'chart.js';

Chart.register(PieController, ArcElement, Tooltip, Legend);

document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('macroChart')?.getContext('2d');
    if (!ctx || !window.foodNutrients) return;

    const nutrients = window.foodNutrients;

    const carbs = parseFloat(nutrients.carbs_g || nutrients.carbs || 0);
    const protein = parseFloat(nutrients.protein_g || 0);
    const fat = parseFloat(nutrients.fat_g || nutrients.fats || 0);

    const carbsCal = carbs * 4;
    const proteinCal = protein * 4;
    const fatCal = fat * 9;
    const totalCal = carbsCal + proteinCal + fatCal;

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Carbs', 'Protein', 'Fat'],
            datasets: [{
                data: [carbs, protein, fat],
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)',  // Blue for carbs
                    'rgba(16, 185, 129, 0.8)',  // Green for protein
                    'rgba(234, 179, 8, 0.8)'    // Yellow for fat
                ],
                borderColor: [
                    'rgba(59, 130, 246, 1)',
                    'rgba(16, 185, 129, 1)',
                    'rgba(234, 179, 8, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((acc, val) => acc + val, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: ${value}g (${percentage}%)`;
                        }
                    },
                    backgroundColor: 'rgba(17, 24, 39, 0.8)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    borderColor: '#374151',
                    borderWidth: 1
                }
            }
        }
    });
});
