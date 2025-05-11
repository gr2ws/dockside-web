<?php

session_start();

require '../scripts/setup_vars.php';
require '../scripts/handle_edit.php';


if (isset($_POST['roomnum'])) {
    $selectedRoom = $_POST['roomnum'];

    initRoomEdit($selectedRoom);
}

$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message']; // Retrieve the message
    unset($_SESSION['message']); // Clear the message from the session
}
$roomnum = isset($_SESSION['room_num']) ? $_SESSION['room_num'] : '';
$type = isset($_SESSION['room_type']) ? $_SESSION['room_type'] : '';
$capacity = isset($_SESSION['room_capacity']) ? $_SESSION['room_capacity'] : '';
$availability = isset($_SESSION['room_availability']) ? $_SESSION['room_availability'] : '';
$price = isset($_SESSION['room_price']) ? $_SESSION['room_price'] : '';
//$bookingid = $_SESSION['booking_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['type'])) {
    $message = handleRoomEdit($roomnum); // generally means successful form submission once this is triggered
    $_SESSION['message'] = $message; // Store the message in a session variable
    header("Location: ./admin_dashboard.php");
    exit(); // Redirect to the same page to avoid resubmission;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard© - Dockside Hotel</title>
    <link rel="stylesheet" href="../styles/admin-dashboard.css">
    <link rel="stylesheet" href="../styles/index.css">
    <?php require_once 'common.php'; ?>
</head>

<body>
    <main class="p-0 m-0 w-100">
        <div class="d-flex" id="wrapper">

            <!-- Page Content -->
            <div id="page-content-wrapper" class="w-100">
                <!-- Top Navigation -->
                <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                    <div class="container-fluid">

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href='../scripts/handle_logout.php'>Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <div class=" container-fluid mt-4 ps-5">
                    <h1 class="mt-4">Welcome to the Admin Dashboard</h1>
                    <p>This is your admin panel where you can manage the rooms.</p>

                    <?php echo $message; ?>

                    <!-- Manage Rooms Section -->
                    <section id="manage-rooms" class="my-5 w-50">
                        <h2>Manage Rooms</h2>
                        <p>Use this section to manage room types, capacity, and availability.</p>
                        <div class="card">
                            <div class="card-header">
                                Room Management
                            </div>
                            <div class="card-body">
                                <form id="editrmForm" method="POST" action="./admin_dashboard.php">
                                    <div class="mb-3">
                                        <label for="roomnum" class="form-label">Room Number</label>
                                        <div class="d-flex justify-center align-center gap-3">
                                            <select class="form-select w-50" id="roomnum" name="roomnum">
                                                <option value="">Select a room:</option>
                                                <?php
                                                seeRooms()
                                                ?>
                                            </select>
                                            <button type="submit" id="check-btn" class="btn btn-success" disabled>Check</button>
                                            <button type="button" id="unlock-btn" class="btn btn-danger" disabled onclick="lockEdits()">Unlock</button>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="type" class="form-label">Room Type</label>
                                        <input type="text" class="form-control" id="type" name="type" placeholder="Enter room type (e.g., Deluxe, Suite)" value="<?php echo isset($type) ? $type : '' ?>" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="capacity" class="form-label">Capacity</label>
                                        <input type="number" class="form-control" id="capacity" name="capacity" placeholder="Enter room capacity" value="<?php echo isset($capacity) ? $capacity : '' ?>" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="availability" class="form-label">Availability</label>
                                        <select class="form-select" id="availability" name="availability" value="<?php echo isset($availability) ? $availability : '' ?>" disabled>
                                            <option value="" <?php echo empty($availability) ? 'selected' : ''; ?> disabled>Select availability status:</option>
                                            <option value="vacant" <?php echo (isset($availability) && $availability === 'vacant') ? 'selected' : ''; ?>>Vacant</option>
                                            <option value="occupied" <?php echo (isset($availability) && $availability === 'occupied') ? 'selected' : ''; ?>>Occupied</option>
                                            <option value="maintenance" <?php echo (isset($availability) && $availability === 'maintenance') ? 'selected' : ''; ?>>Undergoing Maintenance</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Room Price (per night)</label>
                                        <input type="text" class="form-control" id="price" name="price" placeholder="Enter room price (in Php)" value="<?php echo isset($price) ? $price : '' ?>" disabled>
                                    </div>

                                    <!-- flag for conditional data handling based on what form was submitted -->
                                    <input type="hidden" name="roomedit_submit" value="1">

                                    <button id="edit-btn" type="button" class="btn btn-primary" disabled onclick="makeEditable()">Edit Room</button>
                                    <button id="save-btn" type="submit" class="btn btn-primary" disabled>Save Room</button>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../scripts/admin_dbutil.js"></script>
</body>

</html>