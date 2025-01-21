function showSection(sectionId) {
    const sections = document.querySelectorAll('section');
    sections.forEach(section => section.style.display = 'none');
    document.getElementById(sectionId).style.display = 'block';
}
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
