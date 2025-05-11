/**
 * Booking page JavaScript functionality
 * Handles date picking, form validation, and UI interactions
 */
document.addEventListener("DOMContentLoaded", function () {
	// Initialize date pickers
	initDatePickers();

	// Set up form validation
	initFormValidation();
});

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
			}
		}
	});

	// Initialize checkout date picker
	const checkoutPicker = flatpickr("#search-checkout", {
		minDate: new Date().fp_incr(1), // tomorrow
		altInput: true,
		altFormat: "F j, Y",
		dateFormat: "Y-m-d"
	});
}

/**
 * Sets up form validation for the booking search form
 */
function initFormValidation() {
	const searchForm = document.getElementById("search-form");
	if (searchForm) {
		searchForm.addEventListener("submit", function (e) {
			const checkin = document.getElementById("search-checkin").value;
			const checkout = document.getElementById("search-checkout").value;

			if (!checkin || !checkout) {
				e.preventDefault();
				alert("Please select both check-in and check-out dates");
				return false;
			}

			// Convert to Date objects for comparison
			const checkinDate = new Date(checkin);
			const checkoutDate = new Date(checkout);

			if (checkinDate >= checkoutDate) {
				e.preventDefault();
				alert("Check-out date must be after check-in date");
				return false;
			}

			return true;
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
