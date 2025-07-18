function updateStatus() {
    fetch('/api/machine-status') // call Laravel API
        .then(res => res.json()) // turn response into JSON
        .then(data => {
            updateIndicator('left', data.left);   // update left side
            updateIndicator('right', data.right); // update right side
        });
}

function updateIndicator(side, status) {
    const runBox = document.getElementById(`${side}-run`);
    const stopBox = document.getElementById(`${side}-stop`);

    if (status === 'running') {
        runBox.style.backgroundColor = '#4CAF50';  // green
        stopBox.style.backgroundColor = '#ccc';    // gray
    } else {
        runBox.style.backgroundColor = '#ccc';     // gray
        stopBox.style.backgroundColor = '#F44336'; // red
    }
}

// Run on page load
window.addEventListener('DOMContentLoaded', () => {
    updateStatus();
    setInterval(updateStatus, 5000); // repeat every 5s
});
