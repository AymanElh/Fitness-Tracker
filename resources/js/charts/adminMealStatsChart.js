import {Chart, PieController, ArcElement, Tooltip, Legend} from 'chart.js';

Chart.register(PieController, ArcElement, Tooltip, Legend);
document.addEventListener("DOMContentLoaded", function() {
    const chartCanvas = document.getElementById('macronutrientChart');

    if (!chartCanvas) {
        console.error("Chart canvas element not found");
        return;
    }

    if (!window.mealNutrients) {
        console.error("Meal nutrient data not found");
        return;
    }

    const { protein, carbs, fat } = window.mealNutrients;

    console.log("Chart data:", { protein, carbs, fat });

    const proteinCal = protein * 4;  // 4 calories per gram of protein
    const carbsCal = carbs * 4;      // 4 calories per gram of carbs
    const fatCal = fat * 9;          // 9 calories per gram of fat

    new Chart(chartCanvas.getContext('2d'), {
        type: 'pie',  // Changed to pie to match your previous version
        data: {
            labels: ['Protein', 'Carbs', 'Fat'],
            datasets: [{
                data: [protein, carbs, fat],  // Using gram values directly instead of calories
                backgroundColor: [
                    'rgba(56, 189, 248, 0.8)',  // Bright blue for protein
                    'rgba(45, 212, 191, 0.8)',  // Teal for carbs
                    'rgba(168, 85, 247, 0.8)'   // Purple for fat
                ],
                borderColor: [
                    'rgba(56, 189, 248, 1)',
                    'rgba(45, 212, 191, 1)',
                    'rgba(168, 85, 247, 1)'
                ],
                borderWidth: 2,
                hoverBorderWidth: 3,
                hoverBorderColor: '#fff',
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: {
                    top: 10,
                    bottom: 10
                }
            },
            plugins: {
                legend: {
                    display: false,  // We'll use our custom legend below the chart
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((acc, curr) => acc + curr, 0);
                            const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                            return `${label}: ${value}g (${percentage}%)`;
                        }
                    },
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    borderColor: '#334155',
                    borderWidth: 1,
                    padding: 12,
                    boxPadding: 6
                }
            },
            elements: {
                arc: {
                    borderWidth: 2,
                    borderColor: '#1e293b',
                    spacing: 4  // Adds space between the segments
                }
            },
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    });
});
