document.addEventListener('DOMContentLoaded', function() {
    // get all forms
    const addForm = document.getElementById('addForm');
    const updateForm = document.getElementById('updateForm');
    const deleteForm = document.getElementById('deleteForm');

    // add click event listeners to edit and delete buttons
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const bookingId = this.dataset.bookingId;
            showUpdateForm(bookingId);
        });
    });

    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const bookingId = this.dataset.bookingId;
            showDeleteForm(bookingId);
        });
    });

    // function to show update form
    function showUpdateForm(bookingId) {
        // hide other forms
        addForm.classList.add('d-none');
        deleteForm.classList.add('d-none');
        
        // show update form
        updateForm.classList.remove('d-none');
        
        // populate form with booking data
        document.getElementById('updateBookingId').value = bookingId;
        
        // fetch and populate booking details
        const bookingRow = document.querySelector(`tr[data-booking-id="${bookingId}"]`);
        if (bookingRow) {
            const [id, guestName, roomNumber, checkIn, checkOut] = Array.from(bookingRow.cells).map(cell => cell.textContent.trim());
            
            // set form values
            document.getElementById('updateGuestName').value = guestName;
            document.getElementById('updateRoomNumber').value = roomNumber;
            document.getElementById('updateCheckIn').value = checkIn;
            document.getElementById('updateCheckOut').value = checkOut;
        }

        // Scroll to form
        updateForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    // function to show delete form
    function showDeleteForm(bookingId) {
        // hide other forms
        addForm.classList.add('d-none');
        updateForm.classList.add('d-none');
        
        // show delete form
        deleteForm.classList.remove('d-none');
        
        // set booking ID
        document.getElementById('deleteBookingId').value = bookingId;
        
        // scroll to form
        deleteForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    // close forms when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.edit-btn') && 
            !event.target.closest('.delete-btn') && 
            !event.target.closest('#updateForm') && 
            !event.target.closest('#deleteForm')) {
            
            // show add form
            addForm.classList.remove('d-none');
            
            // hide update and delete forms
            updateForm.classList.add('d-none');
            deleteForm.classList.add('d-none');
        }
    });

    // add form submission handlers
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            // add your form submission logic here
            console.log('Form submitted:', this.id);
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // initialize date pickers
    initializeDatePickers();

    // func to initialize date pickers
    function initializeDatePickers() {
        const dateInputs = document.querySelectorAll('.datepicker');
        dateInputs.forEach(input => {
            const fp = flatpickr(input, {
                dateFormat: "Y-m-d",
                minDate: "today",
                enableTime: false,
                altInput: true,
                altFormat: "F j, Y",
                allowInput: true,
                onChange: function(selectedDates, dateStr, instance) {
                    handleDateChange(selectedDates[0], instance.element.id);
                }
            });
        });
    }

    // function to handle date changes
    function handleDateChange(selectedDate, inputId) {
        if (inputId === 'checkIn') {
            updateMinDate('checkOut', selectedDate);
        } else if (inputId === 'updateCheckIn') {
            updateMinDate('updateCheckOut', selectedDate);
        }
    }

    // function to update minimum date for checkout
    function updateMinDate(checkOutId, minDate) {
        const checkOutInput = document.getElementById(checkOutId);
        if (checkOutInput) {
            const checkOutPicker = checkOutInput._flatpickr;
            checkOutPicker.set('minDate', minDate);
            
            // if checkout date is before new check-in date, reset it
            if (checkOutPicker.selectedDates[0] < minDate) {
                checkOutPicker.setDate(minDate);
            }
        }
    }
});