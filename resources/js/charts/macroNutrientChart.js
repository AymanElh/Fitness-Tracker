import {Chart, DoughnutController, ArcElement, Tooltip, Legend} from 'chart.js';

Chart.register(DoughnutController, ArcElement, Tooltip, Legend);

document.addEventListener('DOMContentLoaded', function () {
    if (!window.foodMacros) return;

    const {protein_g = 0, carbs_g = 0, fat_g = 0} = window.foodMacros;

    const proteinCal = protein_g * 4;
    const carbsCal = carbs_g * 4;
    const fatCal = fat_g * 9;

    const ctx = document.getElementById('macronutrientChart')?.getContext('2d');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Protein', 'Carbs', 'Fat'],
            datasets: [{
                data: [proteinCal, carbsCal, fatCal],
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(245, 158, 11, 0.8)'
                ],
                borderColor: [
                    'rgba(59, 130, 246, 1)',
                    'rgba(16, 185, 129, 1)',
                    'rgba(245, 158, 11, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: ${value} cal (${percentage}%)`;
                        }
                    }
                },
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        boxWidth: 15,
                        font: {
                            size: 12
                        }
                    }
                }
            }
        }
    });
});
