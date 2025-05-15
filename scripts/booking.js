/**
 * Booking page JavaScript functionality
 * Handles date picking, form validation, UI interactions, and auto-search
 */
document.addEventListener("DOMContentLoaded", function () {
	// Initialize date pickers
	initDatePickers();

	// Set up form validation
	initFormValidation();

	// Set up room type selection to auto-update
	initRoomTypeAutoUpdate();

	// Auto-submit search when page loads with parameters
	autoSubmitSearchOnLoad();

	// Handle page section visibility based on URL params
	handlePageVisibility();
	// Add event listener for back button to recalculate visibility
	window.addEventListener("popstate", function () {
		handlePageVisibility();
	});

	// Set up back-to-search button handler
	initBackToSearchButton();

	// Set up booking confirmation button handler
	initConfirmationHandler();
});

/**
 * Auto-submits the search form if URL parameters exist
 */
function autoSubmitSearchOnLoad() {
	const urlParams = new URLSearchParams(window.location.search);
	const checkin = urlParams.get("checkin");
	const checkout = urlParams.get("checkout");

	// If both check-in and check-out parameters exist, the form will auto-load results
	// No action needed as PHP already handles this server-side
}

/**
 * Sets up the room type dropdown to trigger search when changed
 */
function initRoomTypeAutoUpdate() {
	const roomTypeSelect = document.getElementById("room-type");
	if (roomTypeSelect) {
		roomTypeSelect.addEventListener("change", function () {
			const checkin = document.getElementById("search-checkin").value;
			const checkout = document.getElementById("search-checkout").value;

			// Only auto-submit if we have both dates, otherwise just save the selection
			if (checkin && checkout) {
				triggerSearch();
			}
		});
	}
}

/**
 * Triggers the search based on current form values
 */
function triggerSearch() {
	const checkin = document.getElementById("search-checkin").value;
	const checkout = document.getElementById("search-checkout").value;
	const roomType = document.getElementById("room-type").value;

	// Only proceed if both dates are set
	if (checkin && checkout) {
		const searchUrl = constructSearchUrl(checkin, checkout, roomType);
		window.location.href = searchUrl;
	}
}

/**
 * Constructs the search URL with parameters
 */
function constructSearchUrl(checkin, checkout, roomType) {
	let url = "booking.php?";
	const params = [];
	if (checkin) params.push(`checkin=${encodeURIComponent(checkin)}`);
	if (checkout) params.push(`checkout=${encodeURIComponent(checkout)}`);
	if (roomType) params.push(`room_type=${encodeURIComponent(roomType)}`);
	return url + params.join("&");
}

/**
 * Initializes and configures the date picker inputs
 */
function initDatePickers() {
	// Initialize checkin date picker
	const checkinPicker = flatpickr("#search-checkin", {
		minDate: "today",
		altInput: true,
		altFormat: "F j, Y",
		dateFormat: "Y-m-d",
		onChange: function (selectedDates, dateStr, instance) {
			// Update checkout min date when checkin changes
			if (selectedDates.length > 0) {
				// Set checkout min date to the day after checkin
				const nextDay = new Date(selectedDates[0]);
				nextDay.setDate(nextDay.getDate() + 1);
				checkoutPicker.set("minDate", nextDay);

				// If checkout date is before new min, reset it
				if (
					checkoutPicker.selectedDates.length > 0 &&
					checkoutPicker.selectedDates[0] <= selectedDates[0]
				) {
					checkoutPicker.setDate(nextDay);
				}

				// Try to auto-submit if we have both dates
				tryAutoSubmit();
			}
		}
	});
	// Initialize checkout date picker
	const checkoutPicker = flatpickr("#search-checkout", {
		minDate: new Date().fp_incr(1), // tomorrow
		altInput: true,
		altFormat: "F j, Y",
		dateFormat: "Y-m-d",
		onChange: function (selectedDates, dateStr, instance) {
			// Try to auto-submit if we have both dates
			tryAutoSubmit();
		}
	});
}

/**
 * Try to auto-submit the search form if both dates are set
 */
function tryAutoSubmit() {
	const checkin = document.getElementById("search-checkin").value;
	const checkout = document.getElementById("search-checkout").value;
	const roomType = document.getElementById("room-type").value;
	const urlParams = new URLSearchParams(window.location.search);
	const hasSelectedRoom = urlParams.has("selected_room");

	// Don't auto-submit if a room is already selected
	if (hasSelectedRoom) {
		return;
	}

	// If both dates are set, auto-submit
	if (checkin && checkout) {
		// Validate dates first
		const checkinDate = new Date(checkin);
		const checkoutDate = new Date(checkout);

		if (checkinDate < checkoutDate) {
			triggerSearch();
		}
	}
}

/**
 * Handles UI visibility based on page state
 */
function handlePageVisibility() {
	const urlParams = new URLSearchParams(window.location.search);
	const hasSelectedRoom = urlParams.has("selected_room");
	const searchSection = document.getElementById("search-section");
	const roomSelectionSection = document.querySelector(
		".room-selection-section"
	);
	const bookingSummarySection = document.querySelector(
		".booking-summary-section"
	);
	const bookingErrorAlert = document.querySelector(".alert-danger");

	if (hasSelectedRoom && searchSection && bookingSummarySection) {
		// Hide search and room selection when a room is selected
		searchSection.style.display = "none";
		if (roomSelectionSection) {
			roomSelectionSection.style.display = "none";
		}
		bookingSummarySection.style.display = "block";
	} else if (bookingSummarySection) {
		// Show search and hide booking summary if no room selected
		if (searchSection) {
			searchSection.style.display = "block";
		}
		if (roomSelectionSection) {
			roomSelectionSection.style.display = "block";
		}
		bookingSummarySection.style.display = "none";
	}

	// If there's a booking error and a selected room, keep the booking summary visible
	if (bookingErrorAlert && hasSelectedRoom && bookingSummarySection) {
		searchSection.style.display = "none";
		if (roomSelectionSection) {
			roomSelectionSection.style.display = "none";
		}
		bookingSummarySection.style.display = "block";
	}
}

/**
 * Sets up form validation for the booking search form
 * Note: With auto-submit enabled, this serves as a fallback
 */
function initFormValidation() {
	const searchForm = document.getElementById("search-form");
	if (searchForm) {
		searchForm.addEventListener("submit", function (e) {
			// Always prevent default since we're using auto-submit
			e.preventDefault();

			const checkin = document.getElementById("search-checkin").value;
			const checkout = document.getElementById("search-checkout").value;

			if (!checkin || !checkout) {
				alert("Please select both check-in and check-out dates");
				return false;
			}

			// Convert to Date objects for comparison
			const checkinDate = new Date(checkin);
			const checkoutDate = new Date(checkout);

			if (checkinDate >= checkoutDate) {
				alert("Check-out date must be after check-in date");
				return false;
			}

			// Trigger the search programmatically instead of form submit
			triggerSearch();
		});
	}

	// Initialize the confirmation form for rebooking action
	const rebookForm = document.getElementById("rebookForm");
	if (rebookForm) {
		rebookForm.addEventListener("submit", function (e) {
			// We don't need to prevent default here as we want the form to submit
			// Just a confirmation before proceeding
			if (
				!confirm(
					"Are you sure you want to rebook this reservation? You'll be redirected to select new dates."
				)
			) {
				e.preventDefault();
			}
		});
	}
}

/**
 * Set up the back-to-search button to clear selected room
 */
function initBackToSearchButton() {
	const backToSearchBtn = document.getElementById("back-to-search-btn");
	if (backToSearchBtn) {
		backToSearchBtn.addEventListener("click", function (e) {
			// Instead of using the default link behavior, we'll navigate manually
			e.preventDefault();

			// Get current parameters but remove the selected_room
			const urlParams = new URLSearchParams(window.location.search);
			urlParams.delete("selected_room");

			// Navigate back to the search view
			const newUrl =
				"booking.php" +
				(urlParams.toString() ? "?" + urlParams.toString() : "");
			window.location.href = newUrl;
		});
	}
}

/**
 * Set up the confirm booking button to check for login and show account dialog if needed
 */
function initConfirmationHandler() {
	const confirmBookingBtn = document.querySelector(
		'button[name="confirm_booking"]'
	);
	if (confirmBookingBtn) {
		confirmBookingBtn.addEventListener("click", function (e) {
			// Get form and add authentication check param
			const form = confirmBookingBtn.form;

			// Add a hidden input to indicate we should check auth
			const checkAuthInput = document.createElement("input");
			checkAuthInput.type = "hidden";
			checkAuthInput.name = "check_auth";
			checkAuthInput.value = "1";

			// Store the booking details in the form even if we need to show the auth modal
			// This ensures we can resume the booking process after login
			form.appendChild(checkAuthInput);
		});
	}
}

/**
 * Show a dialog informing the user they need an account to book
 * @param {string} redirectUrl URL to redirect back to after login/signup
 */
function showAccountRequiredDialog(redirectUrl) {
	// Create modal backdrop
	const backdrop = document.createElement("div");
	backdrop.className = "modal-backdrop fade show";
	document.body.appendChild(backdrop); // Create the modal dialog

	// Add a special parameter to indicate this is a booking confirmation redirect
	// This will help the server know to show the confirmation page, not just search
	let enhancedRedirectUrl = redirectUrl;
	if (
		redirectUrl.includes("selected_room=") &&
		!redirectUrl.includes("confirm_intent=1")
	) {
		enhancedRedirectUrl =
			redirectUrl +
			(redirectUrl.includes("?") ? "&" : "?") +
			"confirm_intent=1";
	}

	const modalHtml = `
		<div class="modal fade show" id="accountRequiredModal" tabindex="-1" aria-labelledby="accountRequiredModalLabel" style="display: block;">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="accountRequiredModalLabel">Account Required</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeAccountModal"></button>
					</div>
					<div class="modal-body">
						<p>You need an account to make online bookings at Dockside Hotel.</p>
						<p>Your booking details will be saved so you can complete your reservation after logging in or signing up.</p>
					</div>
					<div class="modal-footer">
						<a href="/pages/login.php?redirect=${enhancedRedirectUrl}" class="btn btn-primary">Log In</a>
						<a href="/pages/sign_up.php?redirect=${enhancedRedirectUrl}" class="btn btn-success">Create an Account</a>
						<button type="button" class="btn btn-secondary" id="cancelAccountModal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	`;

	// Add the modal to the page
	const modalContainer = document.createElement("div");
	modalContainer.innerHTML = modalHtml;
	document.body.appendChild(modalContainer);

	// Add event listeners to close buttons
	document
		.getElementById("closeAccountModal")
		.addEventListener("click", removeAccountModal);
	document
		.getElementById("cancelAccountModal")
		.addEventListener("click", removeAccountModal);
}

/**
 * Remove the account required modal
 */
function removeAccountModal() {
	// Remove the modal and backdrop
	const modal = document.getElementById("accountRequiredModal");
	if (modal) {
		const modalParent = modal.parentElement;
		if (modalParent) {
			document.body.removeChild(modalParent);
		}
	}

	// Remove the backdrop
	const backdrop = document.querySelector(".modal-backdrop");
	if (backdrop) {
		document.body.removeChild(backdrop);
	}

	// If we're on the booking confirmation page, we can just reload without any special treatment
	// The PHP code will handle properly showing the form again
}
