async function fetchLiveData() {
    try {
        const res = await fetch('/api/latest-data');
        const data = await res.json();

        document.getElementById('left-rpm').innerText = data.left?.rpm ?? 'N/A';
        document.getElementById('left-load').innerText = data.left?.load_kn ?? 'N/A';
        document.getElementById('left-revs').innerText = data.left?.total_revs ?? 'N/A';

        document.getElementById('right-rpm').innerText = data.right?.rpm ?? 'N/A';
        document.getElementById('right-load').innerText = data.right?.load_kn ?? 'N/A';
        document.getElementById('right-revs').innerText = data.right?.total_revs ?? 'N/A';
    } catch (error) {
        console.error('Fetch failed:', error);
    }
}

fetchLiveData();
setInterval(fetchLiveData, 1000);
