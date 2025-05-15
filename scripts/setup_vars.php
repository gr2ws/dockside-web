<?php

function getPersonData()
{
    return [
        'id'       => $_POST['id'] ?? '',
        'fname'    => $_POST['fname'] ?? '',
        'lname'    => $_POST['lname'] ?? '',
        'address'  => $_POST['address'] ?? '',
        'phone'    => $_POST['phone'] ?? '',
        'birthday' => $_POST['birth'] ?? '',
        'email'    => $_POST['email'] ?? '',
        'pass'     => $_POST['password'] ?? '',
    ];
}

function getDbConfig()
{
    # Check first for Heroku JAWSDB_MARIA_URL, or use the one from .env
    # comment out to test local db
    $jawsdb_url = getenv('JAWSDB_MARIA_URL');
    if ($jawsdb_url) {
        $dbparts = parse_url($jawsdb_url);
        return [
            'servername' => $dbparts['host'] . (isset($dbparts['port']) ? ':' . $dbparts['port'] : ''),
            'username'   => $dbparts['user'],
            'password'   => $dbparts['pass'],
            'dbname'     => ltrim($dbparts['path'], '/'),
        ];
    }

    # default local database configuration
    return [
        // 'servername' => '127.0.0.1:3306',
        'servername' => '127.0.0.1:3307',
        'username'   => 'root',
        'password'   => '',
        'dbname'     => 'docksidedb',
    ];
}

function isPersonSet()
{
    return (isset($_POST['fname'])) && (isset($_POST['lname'])) && (isset($_POST['address'])) && (isset($_POST['phone']))
        && (isset($_POST['birth'])) && (isset($_POST['email'])) && (isset($_POST['password']));
}

function initRoomEdit($selectedRoom)
{
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

            // fetch data to plug into session superglobal array.
            $roomnum = $row['room_id'];
            $type = $row['room_type'];
            $capacity = $row['room_capacity'];
            $availability = $row['room_avail'];
            $price = $row['room_price'];

            $_SESSION['room_num'] = $roomnum;
            $_SESSION['room_type'] = $type;
            $_SESSION['room_capacity'] = $capacity;
            $_SESSION['room_availability'] = $availability;
            $_SESSION['room_price'] = $price;
        }
        $conn->close();
    }
}

function seeRooms()
{
    $dbConfig = getDbConfig();
    $conn = new mysqli($dbConfig['servername'], $dbConfig['username'], $dbConfig['password'], $dbConfig['dbname']);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to fetch available rooms
    $sql = "SELECT room_id FROM room";
    $result = $conn->query($sql);

    // Populate the dropdown with available rooms
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $roomId = $row['room_id'];
            $isSelected = (isset($selectedRoom) && $selectedRoom == $roomId) || (isset($_SESSION['room_num']) && $_SESSION['room_num'] == $roomId) ? 'selected' : '';
            echo "<option value='$roomId' $isSelected>$roomId</option>";
        }
    } else {
        echo "<option value='' disabled >No rooms available</option>";
    }

    // Close the connection
    $conn->close();
}

function getRoomData()
{
    return [
        'id'          => $_POST['room_id'] ?? '',
        'type'        => $_POST['type'] ?? '',
        'capacity'    => $_POST['capacity'] ?? '',
        'availability' => $_POST['availability'] ?? '',
        'price'       => $_POST['price'] ?? '',
    ];
}
