import Chart from 'chart.js/auto';
import axios from 'axios';

const createChart = (canvasId, label, color) => {
    const ctx = document.getElementById(canvasId).getContext('2d');
    return new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label,
                data: [],
                borderColor: color,
                fill: false,
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: 10
                    }
                }
            }
        }
    });
};
console.log("Script loaded");

const updateChart = async (chart, side, metric) => {

    try {
        const {
            data
        } = await axios.get('/dashboard/data');
        const timestamp = data[side].timestamp;
        const value = data[side][metric];

        console.log("Updating chart...", side, metric);
        console.log("Timestamp:", timestamp, "Value:", value);

        if (chart.data.labels.length >= 20) {
            chart.data.labels.shift();
            chart.data.datasets[0].data.shift();
        }

        chart.data.labels.push(timestamp);
        chart.data.datasets[0].data.push(value);
        chart.update();
    } catch (e) {
        console.error('Chart update error:', e);
    }
};

window.initCharts = () => {
    const loadChart = createChart('leftLoadChart', 'Load (kN)', 'red');
    const rpmChart = createChart('leftRpmChart', 'RPM', 'blue');

    setInterval(() => updateChart(loadChart, 'left', 'load_kn'), 3000);
    setInterval(() => updateChart(rpmChart, 'left', 'rpm'), 3000);
};

window.addEventListener('DOMContentLoaded', () => {
    window.initCharts();
});