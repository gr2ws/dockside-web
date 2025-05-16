const roomDets = document.getElementById("type");
const roomSelect = document.getElementById("roomnum");
const selectedValue = roomSelect.value;

const availSelect = document.getElementById("availability");
const checkBtn = document.getElementById("check-btn");
const editBtn = document.getElementById("edit-btn");

const bookSelect = document.getElementById("book_id");
const selectedBookingValue = bookSelect.value;

const checkBookingBtn = document.getElementById("check-booking-btn");
const unlockBookingBtn = document.getElementById("unlock-booking-btn");
const editBookingBtn = document.getElementById("edit-booking-btn");
const saveBookingBtn = document.getElementById("save-booking-btn");
const deleteBookingBtn = document.getElementById("delete-booking-btn");

// Trigger once on page load to handle pre-selected values
document.addEventListener("DOMContentLoaded", function () {

    editBtn.disabled = !selectedBookingValue || selectedBookingValue === "";
    editBookingBtn.disabled = !selectedBookingValue || selectedBookingValue === "";

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
    availSelect.style.color = "black";


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

function makeBookingEditable() {
    console.log('hello world');

    ["date_in", "date_out", "bkg_amount", "save-booking-btn", "unlock-booking-btn"].forEach(id => {
        document.getElementById(id).disabled = false;
    });

    // adjust booking id input field css
    bookSelect.style.pointerEvents = "none";
    bookSelect.style.backgroundColor = "#e9ecef";
    bookSelect.style.color = "#6c757d";

    checkBookingBtn.disabled = true;
    editBookingBtn.disabled = false;
    deleteBookingBtn.disabled = false;

}

function lockBookingEdits() {
    ["date_in", "date_out", "bkg_amount", "save-booking-btn", "unlock-booking-btn"].forEach(id => {
        document.getElementById(id).disabled = true;
    });

    // adjust room num input field css
    bookSelect.style.pointerEvents = "auto";
    bookSelect.style.backgroundColor = "white";

    document.getElementById("check-booking-btn").disabled = false;
    document.getElementById("edit-booking-btn").disabled = true;
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