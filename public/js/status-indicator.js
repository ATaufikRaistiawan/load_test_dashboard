function updateStatus() {
    fetch('/api/machine-status') // call Laravel API
        .then(res => res.json()) // turn response into JSON
        .then(data => {
            updateIndicator('left', data.left.isRunning);   // update left side
            updateIndicator('right', data.right.isRunning); // update right side
        });
}

function updateIndicator(side, status) {
    const runBox = document.getElementById(`${side}-run`);
    const stopBox = document.getElementById(`${side}-stop`);

    if (status == 1) {
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
    setInterval(updateStatus, 3000); // repeat every 3s
});
