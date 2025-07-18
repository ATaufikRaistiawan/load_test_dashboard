function updateClock() {
    const now = new Date();

    const time = now.toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: true
    });

    const date = now.toLocaleDateString('en-US', {
        weekday: 'short',
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    });

    document.getElementById('time').textContent = time;
    document.getElementById('date').textContent = date;
}

// Start clock
setInterval(updateClock, 1000);
updateClock(); // Run immediately on load
