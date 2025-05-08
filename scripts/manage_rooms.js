document.addEventListener('DOMContentLoaded', function() {
    // cache DOM elements
    const roomsTableBody = document.getElementById('roomsTableBody');
    const addForm = document.getElementById('addRoomForm');
    const updateForm = document.getElementById('updateRoomForm');
    const deleteForm = document.getElementById('deleteRoomForm');
    
    // initialize forms visibility
    function showAddForm() {
        document.getElementById('addForm').classList.remove('d-none');
        document.getElementById('updateForm').classList.add('d-none');
        document.getElementById('deleteForm').classList.add('d-none');
    }

    // add room rorm handler
    addForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        try {
            const formData = new FormData(this);
            const response = await fetch('php/manage-rooms.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                // refresh the rooms table
                loadRooms();
                // reset the form
                addForm.reset();
                // show success message
                alert('Room added successfully!');
            } else {
                alert(result.message || 'Error adding room');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error adding room');
        }
    });

    // edit button click handler
    roomsTableBody.addEventListener('click', function(e) {
        if (e.target.closest('.edit-btn')) {
            const btn = e.target.closest('.edit-btn');
            const roomId = btn.dataset.roomId;
            const row = btn.closest('tr');
            
            // populate update form
            document.getElementById('updateRoomId').value = roomId;
            document.getElementById('updateRoomNumber').value = row.cells[0].textContent;
            document.getElementById('updateRoomType').value = row.cells[1].textContent;
            document.getElementById('updateCapacity').value = row.cells[2].textContent;
            document.getElementById('updateRate').value = row.cells[3].textContent.replace('₱', '');
            
            // show update form
            document.getElementById('addForm').classList.add('d-none');
            document.getElementById('updateForm').classList.remove('d-none');
            document.getElementById('deleteForm').classList.add('d-none');
        }
        
        if (e.target.closest('.delete-btn')) {
            const btn = e.target.closest('.delete-btn');
            const roomId = btn.dataset.roomId;
            
            // set room ID in delete form
            document.getElementById('deleteRoomId').value = roomId;
            
            // show delete form
            document.getElementById('addForm').classList.add('d-none');
            document.getElementById('updateForm').classList.add('d-none');
            document.getElementById('deleteForm').classList.remove('d-none');
        }
    });

    // update room form handler
    updateForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        try {
            const formData = new FormData(this);
            const response = await fetch('php/manage-rooms.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                // refresh the rooms table
                loadRooms();
                // reset and hide the form
                updateForm.reset();
                showAddForm();
                // show success message
                alert('Room updated successfully!');
            } else {
                alert(result.message || 'Error updating room');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error updating room');
        }
    });

    // delete Room Form Handler
    deleteForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        if (!confirm('Are you sure you want to delete this room?')) {
            return;
        }
        
        try {
            const formData = new FormData(this);
            const response = await fetch('php/manage-rooms.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                // refresh the rooms table
                loadRooms();
                // reset and hide the form
                deleteForm.reset();
                showAddForm();
                // show success message
                alert('Room deleted successfully!');
            } else {
                alert(result.message || 'Error deleting room');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error deleting room');
        }
    });

    // function to load rooms data
    async function loadRooms() {
        try {
            const response = await fetch('php/manage-rooms.php?action=list');
            const rooms = await response.json();
            
            roomsTableBody.innerHTML = rooms.map(room => `
                <tr data-room-id="${room.id}">
                    <td>${room.roomNumber}</td>
                    <td>${room.type}</td>
                    <td>${room.capacity}</td>
                    <td>₱${room.rate}</td>
                    <td><span class="badge bg-${room.status === 'Available' ? 'success' : 'warning'}">${room.status}</span></td>
                    <td>
                        <div class="d-flex justify-content-end gap-2">
                            <button class="btn btn-sm btn-primary edit-btn" 
                                    title="Edit" 
                                    data-room-id="${room.id}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-btn" 
                                    title="Delete" 
                                    data-room-id="${room.id}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        } catch (error) {
            console.error('Error loading rooms:', error);
            alert('Error loading rooms');
        }
    }

    // initial load of rooms
    loadRooms();

    // add cancel buttons functionality
    document.querySelectorAll('.btn-cancel').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            showAddForm();
        });
    });
});