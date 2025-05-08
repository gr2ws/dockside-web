<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Dockside Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../styles/dashboard.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="header-nav navbar navbar-expand-md shadow-sm">
        <div class="container">
            <a class="nav-hotel-name" href="#">Admin Dashboard</a>
            <div class="ms-auto">
                <div class="dropdown">
                    <button class="btn" type="button" data-bs-toggle="dropdown">
                        <i class="bi-person-circle"></i>
                        <span class="d-none d-lg-inline">Admin</span>
                        <i class="bi-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item text-danger" href="logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="container mt-4">
        <div class="row">
            <!-- Left Sidebar -->
            <div class="col-md-2">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <nav>
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a href="#users" class="nav-link active" data-tab="users">
                                        <i class="bi bi-people"></i> Users
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#rooms" class="nav-link" data-tab="rooms">
                                        <i class="bi bi-door-closed"></i> Rooms
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#bookings" class="nav-link" data-tab="bookings">
                                        <i class="bi bi-calendar"></i> Bookings
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Center Content -->
            <div class="col-md-7">
                <!-- Users Section -->
                <div class="content-section" id="users-content">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h2 class="card-title border-bottom pb-2">Users List</h2>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>User ID</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="usersList">
                                        <!-- Sample Row -->
                                        <tr>
                                            <td>#1</td>
                                            <td>johndoe</td>
                                            <td>john@example.com</td>
                                            <td class="text-end">
                                                <button class="btn btn-sm btn-outline-primary me-1" onclick="editUser(1)">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" onclick="showDeleteConfirm('user', 1)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rooms Section -->
                <div class="content-section d-none" id="rooms-content">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h2 class="card-title border-bottom pb-2">Rooms List</h2>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Room No.</th>
                                            <th>Type</th>
                                            <th>Capacity</th>
                                            <th>Rate</th>
                                            <th>Status</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="roomsList">
                                        <!-- Sample Row -->
                                        <tr>
                                            <td>101</td>
                                            <td>Standard</td>
                                            <td>2</td>
                                            <td>₱2,500</td>
                                            <td><span class="badge bg-success">Available</span></td>
                                            <td class="text-end">
                                                <button class="btn btn-sm btn-outline-primary me-1" onclick="editRoom(1)">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" onclick="showDeleteConfirm('room', 1)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bookings Section -->
                <div class="content-section d-none" id="bookings-content">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h2 class="card-title border-bottom pb-2">Bookings List</h2>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Booking ID</th>
                                            <th>User</th>
                                            <th>Room</th>
                                            <th>Check-in</th>
                                            <th>Check-out</th>
                                            <th>Status</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bookingsList">
                                        <!-- Sample Row -->
                                        <tr>
                                            <td>#1001</td>
                                            <td>johndoe</td>
                                            <td>101 - Standard</td>
                                            <td>2024-05-01</td>
                                            <td>2024-05-03</td>
                                            <td><span class="badge bg-warning">Pending</span></td>
                                            <td class="text-end">
                                                <button class="btn btn-sm btn-outline-primary me-1" onclick="editBooking(1)">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" onclick="showDeleteConfirm('booking', 1)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar (Forms) -->
            <div class="col-md-3">
                <!-- Add User Form -->
                <div class="card shadow-sm mb-4" id="addUserForm">
                    <div class="card-body">
                        <h3 class="card-title h5 border-bottom pb-2">Add New User</h3>
                        <form id="userForm">
                            <div class="mb-3">
                                <label class="form-label">Username:</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email:</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password:</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-person-plus"></i> Add User
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Add Room Form -->
                <div class="card shadow-sm mb-4 d-none" id="addRoomForm">
                    <div class="card-body">
                        <h3 class="card-title h5 border-bottom pb-2">Add New Room</h3>
                        <form id="roomForm">
                            <div class="mb-3">
                                <label class="form-label">Room Number:</label>
                                <input type="text" class="form-control" name="room_number" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Room Type:</label>
                                <select class="form-select" name="room_type" required>
                                    <option value="">Select type...</option>
                                    <option value="Standard">Standard</option>
                                    <option value="Deluxe">Deluxe</option>
                                    <option value="Suite">Suite</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Capacity:</label>
                                <input type="number" class="form-control" name="capacity" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Rate/Night:</label>
                                <input type="number" class="form-control" name="rate" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-plus-circle"></i> Add Room
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Add Booking Form -->
                <div class="card shadow-sm mb-4 d-none" id="addBookingForm">
                    <div class="card-body">
                        <h3 class="card-title h5 border-bottom pb-2">Add New Booking</h3>
                        <form id="bookingForm">
                            <div class="mb-3">
                                <label class="form-label">User:</label>
                                <select class="form-select" name="user_id" required>
                                    <option value="">Select user...</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Room:</label>
                                <select class="form-select" name="room_id" required>
                                    <option value="">Select room...</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Check-in:</label>
                                <input type="date" class="form-control" name="check_in" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Check-out:</label>
                                <input type="date" class="form-control" name="check_out" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status:</label>
                                <select class="form-select" name="status" required>
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-plus-circle"></i> Add Booking
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Update Form -->
                <div class="card shadow-sm mb-4 d-none" id="updateForm"></div>

                <!-- Delete Form -->
                <div class="card shadow-sm mb-4 d-none" id="deleteForm"></div>
            </div>
        </div>
    </main>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <p class="mb-0 text-center">Copyright © 2025 Dockside Hotel - All rights reserved.</p>
        </div>
    </footer>

    <!-- Toast Container -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3"></div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../scripts/aud.js"></script>
</body>
</html>