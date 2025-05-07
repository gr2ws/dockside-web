document.addEventListener('DOMContentLoaded', function() {
    // Handle booking buttons
    const bookButtons = document.querySelectorAll('.book-now');
    bookButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const roomCard = e.target.closest('.room-card');
            const roomType = roomCard.querySelector('h2').textContent;
            const price = roomCard.querySelector('.price').textContent;
            
            // Show booking modal
            showBookingModal(roomType, price);
        });
    });

    // Create and append modal to body
    const modal = document.createElement('div');
    modal.className = 'booking-modal';
    modal.innerHTML = `
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Book Your Stay</h2>
            <form id="bookingForm">
                <div class="form-group">
                    <label for="checkIn">Check-in Date:</label>
                    <input type="date" id="checkIn" required>
                </div>
                <div class="form-group">
                    <label for="checkOut">Check-out Date:</label>
                    <input type="date" id="checkOut" required>
                </div>
                <div class="form-group">
                    <label for="guests">Number of Guests:</label>
                    <select id="guests">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </div>
                <button type="submit" class="submit-booking">Confirm Booking</button>
            </form>
        </div>
    `;
    document.body.appendChild(modal);

    // Modal functionality
    function showBookingModal(roomType, price) {
        modal.style.display = 'block';
        const modalTitle = modal.querySelector('h2');
        modalTitle.textContent = `Book ${roomType} - ${price}`;
    }

    // Close modal when clicking X or outside
    const closeBtn = modal.querySelector('.close-modal');
    closeBtn.onclick = () => modal.style.display = 'none';
    window.onclick = (e) => {
        if (e.target == modal) modal.style.display = 'none';
    }

    // Handle form submission
    const bookingForm = document.getElementById('bookingForm');
    bookingForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form data
        const formData = {
            checkIn: document.getElementById('checkIn').value,
            checkOut: document.getElementById('checkOut').value,
            guests: document.getElementById('guests').value
        };

        // Here you would typically send this data to your server
        console.log('Booking details:', formData);
        
        // Show success message
        alert('Thank you for your booking! We will contact you shortly to confirm your reservation.');
        modal.style.display = 'none';
    });
});