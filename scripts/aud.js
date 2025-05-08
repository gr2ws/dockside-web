document.addEventListener('DOMContentLoaded', function() {
    initializeTabHandling();
    initializeFormHandlers();
    loadInitialData();
});

function initializeTabHandling() {
    const navLinks = document.querySelectorAll('.nav-link[data-tab]');
    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const tabId = link.getAttribute('data-tab');
            switchTab(tabId);
        });
    });
}

function switchTab(tabId) {
    // Update navigation
    document.querySelectorAll('.nav-link[data-tab]').forEach(link => {
        link.classList.remove('active');
        if(link.getAttribute('data-tab') === tabId) {
            link.classList.add('active');
        }
    });

    // Update content sections
    document.querySelectorAll('.content-section').forEach(section => {
        section.classList.add('d-none');
        if(section.id === `${tabId}-content`) {
            section.classList.remove('d-none');
        }
    });

    showAddForm(tabId);
    loadDataForTab(tabId);
    history.pushState(null, null, `#${tabId}`);
}

function loadDataForTab(tabId) {
    switch(tabId) {
        case 'users': loadUsers(); break;
        case 'rooms': loadRooms(); break;
        case 'bookings': loadBookings(); break;
    }
}

async function loadUsers() {
    try {
        const response = await fetch('php/admin-op.php?action=listUsers');
        if (!response.ok) throw new Error('Network response was not ok');
        
        const data = await response.json();
        if (!data.success) throw new Error(data.message || 'Failed to load users');
        
        const usersList = document.getElementById('usersList');
        if (!usersList) return;

        usersList.innerHTML = data.data.map(user => `
            <tr>
                <td>#${user.id}</td>
                <td>${escapeHtml(user.username)}</td>
                <td>${escapeHtml(user.email)}</td>
                <td class="text-end">
                    <button class="btn btn-sm btn-outline-primary me-1" onclick="editUser(${user.id})">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="showDeleteConfirm('user', ${user.id})">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `).join('');
    } catch (error) {
        showToast('Error', error.message, 'error');
    }
}

async function loadRooms() {
    try {
        const response = await fetch('php/admin-op.php?action=listRooms');
        if (!response.ok) throw new Error('Network response was not ok');
        
        const data = await response.json();
        if (!data.success) throw new Error(data.message || 'Failed to load rooms');
        
        const roomsList = document.getElementById('roomsList');
        if (!roomsList) return;

        roomsList.innerHTML = data.data.map(room => `
            <tr>
                <td>${escapeHtml(room.room_number)}</td>
                <td>${escapeHtml(room.room_type)}</td>
                <td>${room.capacity}</td>
                <td>₱${parseFloat(room.rate).toLocaleString()}</td>
                <td><span class="badge bg-${room.status === 'Available' ? 'success' : 'warning'}">${room.status}</span></td>
                <td class="text-end">
                    <button class="btn btn-sm btn-outline-primary me-1" onclick="editRoom(${room.id})">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="showDeleteConfirm('room', ${room.id})">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `).join('');
    } catch (error) {
        showToast('Error', error.message, 'error');
    }
}

async function loadBookings() {
    try {
        const response = await fetch('php/admin-op.php?action=listBookings');
        if (!response.ok) throw new Error('Network response was not ok');
        
        const data = await response.json();
        if (!data.success) throw new Error(data.message || 'Failed to load bookings');
        
        const bookingsList = document.getElementById('bookingsList');
        if (!bookingsList) return;

        bookingsList.innerHTML = data.data.map(booking => `
            <tr>
                <td>#${booking.id}</td>
                <td>${escapeHtml(booking.username)}</td>
                <td>${escapeHtml(booking.room_number)} - ${escapeHtml(booking.room_type)}</td>
                <td>${new Date(booking.check_in).toLocaleDateString()}</td>
                <td>${new Date(booking.check_out).toLocaleDateString()}</td>
                <td><span class="badge bg-${getStatusColor(booking.status)}">${booking.status}</span></td>
                <td class="text-end">
                    <button class="btn btn-sm btn-outline-primary me-1" onclick="editBooking(${booking.id})">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="showDeleteConfirm('booking', ${booking.id})">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `).join('');
    } catch (error) {
        showToast('Error', error.message, 'error');
    }
}

function initializeFormHandlers() {
    document.getElementById('userForm')?.addEventListener('submit', handleAddUser);
    document.getElementById('roomForm')?.addEventListener('submit', handleAddRoom);
    document.getElementById('bookingForm')?.addEventListener('submit', handleAddBooking);
}

async function handleAddUser(e) {
    e.preventDefault();
    try {
        const formData = new FormData(e.target);
        formData.append('action', 'addUser');

        const response = await fetch('php/admin-op.php', {
            method: 'POST',
            body: formData
        });
        
        if (!response.ok) throw new Error('Network response was not ok');
        const data = await response.json();
        
        if (!data.success) throw new Error(data.message || 'Failed to add user');
        
        showToast('Success', 'User added successfully');
        e.target.reset();
        loadUsers();
    } catch (error) {
        showToast('Error', error.message, 'error');
    }
}

async function handleAddRoom(e) {
    e.preventDefault();
    try {
        const formData = new FormData(e.target);
        formData.append('action', 'addRoom');

        const response = await fetch('php/admin-op.php', {
            method: 'POST',
            body: formData
        });
        
        if (!response.ok) throw new Error('Network response was not ok');
        const data = await response.json();
        
        if (!data.success) throw new Error(data.message || 'Failed to add room');
        
        showToast('Success', 'Room added successfully');
        e.target.reset();
        loadRooms();
    } catch (error) {
        showToast('Error', error.message, 'error');
    }
}

async function handleAddBooking(e) {
    e.preventDefault();
    try {
        const formData = new FormData(e.target);
        formData.append('action', 'addBooking');

        const response = await fetch('php/admin-op.php', {
            method: 'POST',
            body: formData
        });
        
        if (!response.ok) throw new Error('Network response was not ok');
        const data = await response.json();
        
        if (!data.success) throw new Error(data.message || 'Failed to add booking');
        
        showToast('Success', 'Booking added successfully');
        e.target.reset();
        loadBookings();
    } catch (error) {
        showToast('Error', error.message, 'error');
    }
}

function editUser(userId) {
    hideAllForms();
    const updateForm = document.getElementById('updateForm');
    if (!updateForm) return;

    updateForm.classList.remove('d-none');
    updateForm.innerHTML = `
        <div class="card-body">
            <h3 class="card-title h5 border-bottom pb-2">Edit User</h3>
            <form id="editUserForm" onsubmit="handleUpdateUser(event, ${userId})">
                <div class="mb-3">
                    <label class="form-label">Username:</label>
                    <input type="text" class="form-control" name="username" id="editUsername" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email:</label>
                    <input type="email" class="form-control" name="email" id="editEmail" required>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-secondary w-50" onclick="cancelEdit('users')">
                        <i class="bi bi-arrow-left"></i> Back
                    </button>
                    <button type="submit" class="btn btn-primary w-50">
                        <i class="bi bi-check-lg"></i> Update
                    </button>
                </div>
            </form>
        </div>
    `;

    fetchUserData(userId);
}

function editRoom(roomId) {
    hideAllForms();
    const updateForm = document.getElementById('updateForm');
    if (!updateForm) return;

    updateForm.classList.remove('d-none');
    updateForm.innerHTML = `
        <div class="card-body">
            <h3 class="card-title h5 border-bottom pb-2">Edit Room</h3>
            <form id="editRoomForm" onsubmit="handleUpdateRoom(event, ${roomId})">
                <div class="mb-3">
                    <label class="form-label">Room Number:</label>
                    <input type="text" class="form-control" name="room_number" id="editRoomNumber" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Room Type:</label>
                    <select class="form-select" name="room_type" id="editRoomType" required>
                        <option value="Standard">Standard</option>
                        <option value="Deluxe">Deluxe</option>
                        <option value="Suite">Suite</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Capacity:</label>
                    <input type="number" class="form-control" name="capacity" id="editCapacity" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Rate/Night:</label>
                    <input type="number" class="form-control" name="rate" id="editRate" required>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-secondary w-50" onclick="cancelEdit('rooms')">
                        <i class="bi bi-arrow-left"></i> Back
                    </button>
                    <button type="submit" class="btn btn-primary w-50">
                        <i class="bi bi-check-lg"></i> Update
                    </button>
                </div>
            </form>
        </div>
    `;

    fetchRoomData(roomId);
}

function editBooking(bookingId) {
    hideAllForms();
    const updateForm = document.getElementById('updateForm');
    if (!updateForm) return;

    updateForm.classList.remove('d-none');
    updateForm.innerHTML = `
        <div class="card-body">
            <h3 class="card-title h5 border-bottom pb-2">Edit Booking</h3>
            <form id="editBookingForm" onsubmit="handleUpdateBooking(event, ${bookingId})">
                <div class="mb-3">
                    <label class="form-label">Status:</label>
                    <select class="form-select" name="status" id="editStatus" required>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-secondary w-50" onclick="cancelEdit('bookings')">
                        <i class="bi bi-arrow-left"></i> Back
                    </button>
                    <button type="submit" class="btn btn-primary w-50">
                        <i class="bi bi-check-lg"></i> Update
                    </button>
                </div>
            </form>
        </div>
    `;

    fetchBookingData(bookingId);
}

async function fetchUserData(userId) {
    try {
        const response = await fetch(`php/admin-op.php?action=getUser&user_id=${userId}`);
        if (!response.ok) throw new Error('Network response was not ok');
        
        const data = await response.json();
        if (!data.success) throw new Error(data.message || 'Failed to fetch user data');
        
        document.getElementById('editUsername').value = data.data.username;
        document.getElementById('editEmail').value = data.data.email;
    } catch (error) {
        showToast('Error', error.message, 'error');
    }
}

async function fetchRoomData(roomId) {
    try {
        const response = await fetch(`php/admin-op.php?action=getRoom&room_id=${roomId}`);
        if (!response.ok) throw new Error('Network response was not ok');
        
        const data = await response.json();
        if (!data.success) throw new Error(data.message || 'Failed to fetch room data');
        
        document.getElementById('editRoomNumber').value = data.data.room_number;
        document.getElementById('editRoomType').value = data.data.room_type;
        document.getElementById('editCapacity').value = data.data.capacity;
        document.getElementById('editRate').value = data.data.rate;
    } catch (error) {
        showToast('Error', error.message, 'error');
    }
}

async function fetchBookingData(bookingId) {
    try {
        const response = await fetch(`php/admin-op.php?action=getBooking&booking_id=${bookingId}`);
        if (!response.ok) throw new Error('Network response was not ok');
        
        const data = await response.json();
        if (!data.success) throw new Error(data.message || 'Failed to fetch booking data');
        
        document.getElementById('editStatus').value = data.data.status;
    } catch (error) {
        showToast('Error', error.message, 'error');
    }
}

async function handleUpdateUser(e, userId) {
    e.preventDefault();
    try {
        const formData = new FormData(e.target);
        formData.append('action', 'updateUser');
        formData.append('user_id', userId);

        const response = await fetch('php/admin-op.php', {
            method: 'POST',
            body: formData
        });

        if (!response.ok) throw new Error('Network response was not ok');
        const data = await response.json();
        
        if (!data.success) throw new Error(data.message || 'Failed to update user');
        
        showToast('Success', 'User updated successfully');
        cancelEdit('users');
        loadUsers();
    } catch (error) {
        showToast('Error', error.message, 'error');
    }
}

async function handleUpdateRoom(e, roomId) {
    e.preventDefault();
    try {
        const formData = new FormData(e.target);
        formData.append('action', 'updateRoom');
        formData.append('room_id', roomId);

        const response = await fetch('php/admin-op.php', {
            method: 'POST',
            body: formData
        });

        if (!response.ok) throw new Error('Network response was not ok');
        const data = await response.json();
        
        if (!data.success) throw new Error(data.message || 'Failed to update room');
        
        showToast('Success', 'Room updated successfully');
        cancelEdit('rooms');
        loadRooms();
    } catch (error) {
        showToast('Error', error.message, 'error');
    }
}

async function handleUpdateBooking(e, bookingId) {
    e.preventDefault();
    try {
        const formData = new FormData(e.target);
        formData.append('action', 'updateBooking');
        formData.append('booking_id', bookingId);

        const response = await fetch('php/admin-op.php', {
            method: 'POST',
            body: formData
        });

        if (!response.ok) throw new Error('Network response was not ok');
        const data = await response.json();
        
        if (!data.success) throw new Error(data.message || 'Failed to update booking');
        
        showToast('Success', 'Booking updated successfully');
        cancelEdit('bookings');
        loadBookings();
    } catch (error) {
        showToast('Error', error.message, 'error');
    }
}

function showDeleteConfirm(type, id) {
    hideAllForms();
    const deleteForm = document.getElementById('deleteForm');
    if (!deleteForm) return;

    deleteForm.classList.remove('d-none');
    deleteForm.innerHTML = `
        <div class="card-body">
            <h3 class="card-title h5 border-bottom pb-2">Confirm Delete</h3>
            <p class="text-danger">Are you sure you want to delete this ${type}?</p>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-secondary w-50" onclick="cancelEdit('${type}s')">
                    <i class="bi bi-arrow-left"></i> Cancel
                </button>
                <button type="button" class="btn btn-danger w-50" onclick="handleDelete('${type}', ${id})">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </div>
        </div>
    `;
}

async function handleDelete(type, id) {
    try {
        const response = await fetch('php/admin-op.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=delete${type}&${type}_id=${id}`
        });
        
        if (!response.ok) throw new Error('Network response was not ok');
        const data = await response.json();
        
        if (!data.success) throw new Error(data.message || `Failed to delete ${type}`);
        
        showToast('Success', `${type} deleted successfully`);
        cancelEdit(`${type}s`);
        loadDataForTab(`${type}s`);
    } catch (error) {
        showToast('Error', error.message, 'error');
    }
}

function cancelEdit(type) {
    hideAllForms();
    showAddForm(type);
}

function hideAllForms() {
    ['addUserForm', 'addRoomForm', 'addBookingForm', 'updateForm', 'deleteForm'].forEach(formId => {
        document.getElementById(formId)?.classList.add('d-none');
    });
}

function showAddForm(type) {
    hideAllForms();
    const formId = `add${type.slice(0, -1).charAt(0).toUpperCase() + type.slice(1, -1)}Form`;
    document.getElementById(formId)?.classList.remove('d-none');
}

function showToast(title, message, type = 'success') {
    const toastContainer = document.querySelector('.toast-container');
    if (!toastContainer) return;

    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-white bg-${type === 'error' ? 'danger' : 'success'}`;
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <strong>${escapeHtml(title)}</strong><br>
                ${escapeHtml(message)}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;

    toastContainer.appendChild(toast);
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();

    toast.addEventListener('hidden.bs.toast', () => toast.remove());
}

function getStatusColor(status) {
    switch(status.toLowerCase()) {
        case 'confirmed': return 'success';
        case 'pending': return 'warning';
        case 'cancelled': return 'danger';
        default: return 'secondary';
    }
}

function escapeHtml(str) {
    if (typeof str !== 'string') return '';
    return str
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

function loadInitialData() {
    const hash = window.location.hash.slice(1) || 'users';
    switchTab(hash);
}