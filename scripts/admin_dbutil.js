const roomSelect = document.getElementById("roomnum");
const roomDets = document.getElementById("type");

const checkBtn = document.getElementById("check-btn");
const editBtn = document.getElementById("edit-btn");

// Enable Check button only if a valid room is selected
roomSelect.addEventListener("change", function () {
    const selectedValue = roomSelect.value;
    const selectedDetails = roomDets.value;

    checkBtn.disabled = !selectedValue || selectedValue === "";
});

// Trigger once on page load to handle pre-selected values
document.addEventListener("DOMContentLoaded", function () {
    const selectedValue = roomSelect.value;
    const typeValue = document.getElementById("type").value;

    checkBtn.disabled = !selectedValue || selectedValue === "";

    // Enable only if the room is already populated from the server
    if (typeValue) {
        editBtn.disabled = false;
    }

});

function makeEditable() {
    ["type", "capacity", "availability", "price", "save-btn", "unlock-btn"].forEach(id => {
        document.getElementById(id).disabled = false;
    });

    // Disable the room number dropdown
    const roomSelect = document.getElementById("roomnum");
    roomSelect.disabled = true;
    roomSelect.style.pointerEvents = "none"; // Prevent interaction
    document.getElementById("check-btn").disabled = true;
    document.getElementById("edit-btn").disabled = true;

}

function lockEdits() {
    ["type", "capacity", "availability", "price", "save-btn", "unlock-btn"].forEach(id => {
        document.getElementById(id).disabled = true;
    });

    // Enable the room number dropdown
    const roomSelect = document.getElementById("roomnum");
    roomSelect.disabled = false;
    roomSelect.style.pointerEvents = "auto"; // Allow interaction

    document.getElementById("check-btn").disabled = false;
    document.getElementById("edit-btn").disabled = false;
}