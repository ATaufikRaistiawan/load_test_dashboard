import './bootstrap';
import Chart from 'chart.js/auto';
import axios from 'axios';
import './chart';


const fetchAndUpdate = async (chart, side) => {
    const { data } = await axios.get('/dashboard/data'); // your getLatestJson route

    const timestamps = [data[side].timestamp];
    const load = [data[side].load_kn];
    const rpm = [data[side].rpm];

    chart.data.labels = timestamps;
    chart.data.datasets[0].data = load;
    chart.data.datasets[1].data = rpm;
    chart.update();
};

window.initCharts = () => {
    const ctx = document.getElementById('myChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [
                { label: 'Load (kN)', data: [], borderColor: 'red' },
                { label: 'RPM', data: [], borderColor: 'blue' }
            ]
        },
        options: { responsive: true }
    });

    setInterval(() => fetchAndUpdate(chart, 'left'), 3000); // update every 3s
};

// Optional: You can register custom plugins or styles here
window.Chart = Chart;
