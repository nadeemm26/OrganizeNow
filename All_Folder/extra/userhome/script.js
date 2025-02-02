// JavaScript to Toggle Sections
function showSection(sectionId) {
    document.querySelectorAll('.admin-section').forEach(section => {
        section.style.display = 'none';
    });
    document.getElementById(sectionId).style.display = 'block';
}

document.querySelector('.admin-link').addEventListener('click', function () {
    document.getElementById('dashboard').style.display = 'flex';
});