import { Chart, LineController, LineElement, PointElement, LinearScale, Title, CategoryScale, Tooltip, Filler } from 'chart.js';

Chart.register(LineController, LineElement, PointElement, LinearScale, Title, CategoryScale, Tooltip, Filler);

document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('userRegistrationChart')?.getContext('2d');
    if (!ctx || !window.userChartData) return;

    const labels = window.userChartData.labels;
    const data = window.userChartData.counts;
    console.log(labels, data);
    const gradientFill = ctx.createLinearGradient(0, 0, 0, 400);
    gradientFill.addColorStop(0, 'rgba(79, 70, 229, 0.2)');
    gradientFill.addColorStop(1, 'rgba(79, 70, 229, 0.0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'New Registrations',
                data: data,
                borderColor: 'rgba(79, 70, 229, 1)',
                backgroundColor: gradientFill,
                tension: 0.3,
                fill: true,
                pointBackgroundColor: 'rgba(79, 70, 229, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(17, 24, 39, 0.9)',
                    padding: 12,
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgba(255, 255, 255, 0.1)',
                    borderWidth: 1,
                    displayColors: false,
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#9CA3AF', font: { size: 11 } }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(243, 244, 246, 1)', drawBorder: false },
                    ticks: { stepSize: 1, color: '#9CA3AF', font: { size: 11 } }
                }
            }
        }
    });
});
