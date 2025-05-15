const roomDets = document.getElementById("type");
const roomSelect = document.getElementById("roomnum");
const selectedValue = roomSelect.value;
const availSelect = document.getElementById("availability");
const checkBtn = document.getElementById("check-btn");
const editBtn = document.getElementById("edit-btn");

// Trigger once on page load to handle pre-selected values
document.addEventListener("DOMContentLoaded", function () {

    editBtn.disabled = !selectedValue || selectedValue === "";

});

function makeEditable() {
    ["type", "capacity", "availability", "price", "save-btn", "unlock-btn"].forEach(id => {
        document.getElementById(id).disabled = false;
    });

    console.log("here");

    availSelect.disabled = false;

    // adjust room num input field css
    roomSelect.style.pointerEvents = "none";
    roomSelect.style.backgroundColor = "#e9ecef";
    roomSelect.style.color = "#6c757d";

    //adjust availability style
    availSelect.style.pointerEvents = "auto";
    availSelect.style.backgroundColor = "white";

    checkBtn.disabled = true;
    editBtn.disabled = false;

}

function lockEdits() {
    ["type", "capacity", "availability", "price", "save-btn", "unlock-btn"].forEach(id => {
        document.getElementById(id).disabled = true;
    });

    // adjust room num input field css
    roomSelect.style.pointerEvents = "auto";
    roomSelect.style.backgroundColor = "white";

    document.getElementById("check-btn").disabled = false;
    document.getElementById("edit-btn").disabled = true;

    //adjust availability style
    availSelect.style.pointerEvents = "none";
    availSelect.style.backgroundColor = "#e9ecef";
    availSelect.style.color = "#6c757d";
}


document.addEventListener('DOMContentLoaded', function () {
    // Tab switching functionality
    const navLinks = document.querySelectorAll('.nav-link[data-tab]');
    const contentSections = document.querySelectorAll('.content-section');

    function switchTab(tabId) {
        // Update navigation links
        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('data-tab') === tabId) {
                link.classList.add('active');
            }
        });

        // Update content sections
        contentSections.forEach(section => {
            section.classList.add('d-none');
            if (section.id === `${tabId}-content`) {
                section.classList.remove('d-none');
            }
        });

        // Update URL hash without scrolling
        history.pushState(null, null, `#${tabId}`);
    }

    // Add click handlers to nav links
    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const tabId = link.getAttribute('data-tab');
            switchTab(tabId);
        });
    });

    // Handle browser back/forward buttons
    window.addEventListener('popstate', () => {
        const hash = window.location.hash.slice(1) || 'dashboard';
        switchTab(hash);
    });

    // Load initial tab based on URL hash or default to dashboard
    const initialTab = window.location.hash.slice(1) || 'dashboard';
    switchTab(initialTab);

});