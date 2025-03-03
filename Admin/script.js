function updateClock() {
    const clock = document.getElementById('clock');
    if (clock) {
        const now = new Date();
        const time = now.toLocaleTimeString();
        const date = now.toLocaleDateString();
        clock.textContent = `${date} | ${time}`;
    }
}

setInterval(updateClock, 1000);
updateClock();
