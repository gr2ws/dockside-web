document.addEventListener("DOMContentLoaded", function () {
	// Tab switching functionality
	const navLinks = document.querySelectorAll(".nav-link[data-tab]");
	const contentSections = document.querySelectorAll(".content-section");

	function switchTab(tabId) {
		// Update navigation links
		navLinks.forEach((link) => {
			link.classList.remove("active");
			if (link.getAttribute("data-tab") === tabId) {
				link.classList.add("active");
			}
		});

		// Update content sections
		contentSections.forEach((section) => {
			section.classList.add("d-none");
			if (section.id === `${tabId}-content`) {
				section.classList.remove("d-none");
			}
		});

		// Update URL hash without scrolling
		history.pushState(null, null, `#${tabId}`);
	}

	// Add click handlers to nav links
	navLinks.forEach((link) => {
		link.addEventListener("click", (e) => {
			e.preventDefault();
			const tabId = link.getAttribute("data-tab");
			switchTab(tabId);
		});
	});

	// Handle browser back/forward buttons
	window.addEventListener("popstate", () => {
		const hash = window.location.hash.slice(1) || "bookings";
		switchTab(hash);
	});

	// Load initial tab based on URL hash or default to bookings
	const initialTab = window.location.hash.slice(1) || "bookings";
	switchTab(initialTab);

	// Add toast functionality
	function showToast(message, type = "success") {
		const toastEl = document.getElementById("liveToast");
		const toastBody = document.getElementById("toastMessage");

		// Set the toast color class
		toastEl.className = `toast align-items-center text-bg-${type} border-0`;

		// Update message
		toastBody.textContent = message;

		// Show the toast using Bootstrap's JS API
		const toast = new bootstrap.Toast(toastEl);
		toast.show();
	}

	// Expose toast functions to window for potential use in inline scripts
	window.showSuccess = function (message) {
		showToast(message, "success");
	};

	window.showError = function (message) {
		showToast(message, "danger");
	};

	// Initialize birthday date picker with max date of today
	if (document.getElementById("birth")) {
		flatpickr("#birth", {
			maxDate: "today",
			altInput: true,
			altFormat: "F j, Y",
			dateFormat: "Y-m-d",
			allowInput: true,
			onOpen: function () {
				// Only allow opening if the field is not disabled
				if (this.input.disabled) {
					this.close();
				}
			}
		});
	}
});

async function loadReservations() {
    try {
        const response = await fetch('php/get_user_reservations.php');
        const data = await response.json();

        if (data.success) {
            displayReservations(data.reservations);
        } else {
            throw new Error(data.message);
        }
    } catch (error) {
        console.error('Error loading reservations:', error);
        // Handle error display
    }

  // Function to remove alert messages when switching tabs
function ridMessage() {
	if (document.querySelector(".alert")) {
		document.querySelector(".alert").classList.remove("d-flex");
		document.querySelector(".alert").classList.add("d-none");
	}
}

// Function to toggle profile form fields between editable and non-editable
function makeEditable() {
	// Get the button and form fields
	const editButton = document.querySelector("button[onclick='makeEditable()']");
	const formFields = document.querySelectorAll(
		"#profileForm input:not([type='hidden']), #profileForm textarea"
	);

	// Get the current state (disabled or not)
	const isDisabled = formFields[0].disabled;

	// Toggle disabled state for all fields
	formFields.forEach((field) => (field.disabled = !isDisabled));

	// Update button text based on new state
	editButton.textContent = isDisabled ? "Cancel Editing" : "Edit Profile";
}

// Function to show password input as plain text
function showPass(inputId, showBtnId, hideBtnId) {
	const input = document.getElementById(inputId);
	const showBtn = document.getElementById(showBtnId);
	const hideBtn = document.getElementById(hideBtnId);

	input.type = "text";
	showBtn.classList.add("d-none");
	showBtn.classList.remove("d-block");
	hideBtn.classList.remove("d-none");
	hideBtn.classList.add("d-block");
}

// Function to hide password input as password field
function hidePass(inputId, showBtnId, hideBtnId) {
	const input = document.getElementById(inputId);
	const showBtn = document.getElementById(showBtnId);
	const hideBtn = document.getElementById(hideBtnId);

	input.type = "password";
	hideBtn.classList.add("d-none");
	hideBtn.classList.remove("d-block");
	showBtn.classList.remove("d-none");
	showBtn.classList.add("d-block");
}

// Booking history filter functionality (executes after DOM is fully loaded)
document.addEventListener("DOMContentLoaded", function () {
	const bookingFilters = document.querySelectorAll(".booking-filter");

	if (bookingFilters.length > 0) {
		bookingFilters.forEach((filter) => {
			filter.addEventListener("click", function (e) {
				e.preventDefault();

				// Update active filter
				bookingFilters.forEach((f) => f.classList.remove("active"));
				this.classList.add("active");

				const filterType = this.getAttribute("data-filter");
				const bookingRows = document.querySelectorAll(
					"#history-content table tbody tr"
				);

				// Filter table rows
				bookingRows.forEach((row) => {
					const statusBadge = row.querySelector(".badge");
					const statusText = statusBadge
						? statusBadge.textContent.trim().toLowerCase()
						: "";

					if (filterType === "all") {
						row.style.display = "";
					} else if (filterType === statusText.toLowerCase()) {
						row.style.display = "";
					} else {
						row.style.display = "none";
					}
				});
			});
		});
	}
});
