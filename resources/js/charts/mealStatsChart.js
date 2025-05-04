import {Chart, PieController, ArcElement, Tooltip, Legend} from "chart.js";

Chart.register(PieController, ArcElement, Tooltip, Legend);

document.addEventListener("DOMContentLoaded", function() {
    const protein = window.mealProtein ?? 0;
    const carbs = window.mealCarbs ?? 0;
    const fat = window.mealFat ?? 0;
    console.log(protein, carbs, fat);
    const total = protein + carbs + fat;
    const ctx = document.getElementById('macroChart').getContext('2d');

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Protein', 'Carbs', 'Fat'],
            datasets: [{
                data: [protein, carbs, fat],
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)',  // Blue
                    'rgba(234, 179, 8, 0.8)',   // Yellow
                    'rgba(239, 68, 68, 0.8)'    // Red
                ],
                borderColor: [
                    'rgba(59, 130, 246, 1)',
                    'rgba(234, 179, 8, 1)',
                    'rgba(239, 68, 68, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.raw || 0;
                            const label = context.label || '';
                            const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                            return `${label}: ${value}g (${percentage}%)`;
                        }
                    },
                    backgroundColor: 'rgba(17, 24, 39, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#374151',
                    borderWidth: 1
                }
            }
        }
    });
})
