<?php

session_start();

require '../scripts/setup_vars.php';
require '../scripts/handle_edit.php';


if (isset($_POST['roomnum'])) {
    $selectedRoom = $_POST['roomnum'];

    $dbConfig = getDbConfig();
    $servername = $dbConfig['servername'];
    $username = $dbConfig['username'];
    $password = $dbConfig['password'];
    $dbname = $dbConfig['dbname'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Build and execute SQL query
        $SQLcommand = "SELECT * FROM room WHERE room_id = $selectedRoom";
        $result = $conn->query($SQLcommand);

        // Check if the query returned a result
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc(); // Fetch the row as an associative array
            $roomid = $row['room_id'];
            $type = $row['room_type'];
            $capacity = $row['room_capacity'];
            $availability = $row['room_avail'];
            $price = $row['room_price'];
        }
        $conn->close();
    }
}


$roomnum = isset($_SESSION['id']) ? $_SESSION['id'] : '';
$roomtype = isset($_SESSION['room_type']) ? $_SESSION['room_type'] : '';
$roomcapacity = isset($_SESSION['room_capacity']) ? $_SESSION['room_capacity'] : '';
$roomavailability = isset($_SESSION['room_availability']) ? $_SESSION['room_availability'] : '';
$roomprice = isset($_SESSION['room_price']) ? $_SESSION['room_price'] : '';
//$bookingid = $_SESSION['booking_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['roomedit_submit'])) {
    $message = handleRoomEdit($_POST['roomnum']);
} else $message = '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Dockside Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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

                                                $dbConfig = getDbConfig();
                                                $conn = new mysqli($dbConfig['servername'], $dbConfig['username'], $dbConfig['password'], $dbConfig['dbname']);

                                                // Check connection
                                                if ($conn->connect_error) {
                                                    die("Connection failed: " . $conn->connect_error);
                                                }

                                                // Query to fetch available rooms
                                                $sql = "SELECT room_id FROM room WHERE room_avail = 'vacant'";
                                                $result = $conn->query($sql);

                                                // Populate the dropdown with available rooms
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        $roomId = $row['room_id'];
                                                        $isSelected = isset($selectedRoom) && $selectedRoom == $roomId ? 'selected' : '';
                                                        echo "<option value='$roomId' $isSelected>Room $roomId</option>";
                                                    }
                                                } else {
                                                    echo "<option value='' disabled >No rooms available</option>";
                                                }

                                                // Close the connection
                                                $conn->close();
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
                                        <select class="form-select" id="availability" name="availability" placeholder="-" value="<?php echo isset($availability) ? $availability : '' ?>" disabled>
                                            <option value="available">Available</option>
                                            <option value="unavailable">Unavailable</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Room Price</label>
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
    <script>
        const roomSelect = document.getElementById("roomnum");
        const roomDets = document.getElementById("type");

        const checkBtn = document.getElementById("check-btn");
        const editBtn = document.getElementById("edit-btn");

        // Enable Check button only if a valid room is selected
        roomSelect.addEventListener("change", function() {
            const selectedValue = roomSelect.value;
            const selectedDetails = roomDets.value;

            checkBtn.disabled = !selectedValue || selectedValue === "";
        });

        // Trigger once on page load to handle pre-selected values
        document.addEventListener("DOMContentLoaded", function() {
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
    </script>
</body>

</html>