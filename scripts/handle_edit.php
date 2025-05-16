<?php

require_once __DIR__ . '/setup_vars.php';

function handleEdit($id)
{
    // get db config data
    $dbConfig = getDbConfig();
    $servername = $dbConfig['servername'];
    $username = $dbConfig['username'];
    $password = $dbConfig['password'];
    $dbname = $dbConfig['dbname'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        return '<div class="alert alert-danger mt-3">Database connection failed.</div>';
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Get data from person table
        $personData = getPersonData();
        $new_fname   = $personData['fname'];
        $new_lname   = $personData['lname'];
        $new_address = $personData['address'];
        $new_phone   = $personData['phone'];
        $new_birth   = $personData['birthday'];

        // Build and execute SQL query
        $SQLcommand = "UPDATE person 
               SET 
                   pers_fname     = '$new_fname',
                   pers_lname     = '$new_lname',
                   pers_address   = '$new_address',
                   pers_number    = '$new_phone',
                   pers_birthdate = '$new_birth'
               WHERE pers_id = $id";

        if ($conn->query($SQLcommand) === TRUE) {
            $_SESSION['fname']    = $new_fname;
            $_SESSION['lname']    = $new_lname;
            $_SESSION['address']  = $new_address;
            $_SESSION['phone']    = $new_phone;
            $_SESSION['birthday'] = $new_birth;

            // Set a success message
            return '<div class="alert alert-success d-flex align-items-center mb-n2 w-100" role="alert">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round-check-icon lucide-user-round-check"><path d="M2 21a8 8 0 0 1 13.292-6"/><circle cx="10" cy="8" r="5"/><path d="m16 19 2 2 4-4"/></svg>
                                        <div class="ms-3">
                                            User profile edited successfully!
                                        </div>
                                    </div>';
        } else {
            return '<div class="alert alert-danger d-flex align-items-center mt-4 w-25" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-circle-x me-2"><circle cx="12" cy="12" r="10"/>
                        <path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
                    <div>Something went wrong. Please try again.</div>
                </div>';
        }
    }
}

function handleRoomEdit($roomnum)
{
    // get db config data
    $dbConfig = getDbConfig();
    $servername = $dbConfig['servername'];
    $username = $dbConfig['username'];
    $password = $dbConfig['password'];
    $dbname = $dbConfig['dbname'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        return '<div class="alert alert-danger mt-3">Database connection failed.</div>';
    }

    // Get data from person table
    $roomData = getRoomData();
    $new_type   = $roomData['type'];
    $new_capacity = $roomData['capacity'];
    $new_availability = $roomData['availability'];
    $new_price = $roomData['price'];

    // Build and execute SQL query
    $SQLcommand = "UPDATE room 
               SET 
                   room_type     = '$new_type',
                   room_capacity  = $new_capacity,
                   room_avail     = '$new_availability',
                   room_price     = $new_price
               WHERE room_id = $roomnum";

    if ($conn->query($SQLcommand) === TRUE) {
        $_SESSION['room_num']        = $roomnum;
        $_SESSION['room_type']     = $new_type;
        $_SESSION['room_capacity']  = $new_capacity;
        $_SESSION['room_availability'] = $new_availability;
        $_SESSION['room_price']     = $new_price;

        // Set a success message
        return '<div class="alert alert-success d-flex align-items-center w-100" role="alert">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round-check-icon lucide-user-round-check"><path d="M2 21a8 8 0 0 1 13.292-6"/><circle cx="10" cy="8" r="5"/><path d="m16 19 2 2 4-4"/></svg>
                                        <div class="ms-3">
                                            Room edited successfully!
                                        </div>
                                    </div>';
    } else {
        return '<div class="alert alert-danger d-flex align-items-center w-100" role="alert">
                    <   svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-circle-x me-2"><circle cx="12" cy="12" r="10"/>
                        <path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
                    <div>Something went wrong. Please try again.</div>
                </div>';
    }
}

function handleBookingEdit($book_id)
{
    // get db config data
    $dbConfig = getDbConfig();
    $servername = $dbConfig['servername'];
    $username = $dbConfig['username'];
    $password = $dbConfig['password'];
    $dbname = $dbConfig['dbname'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        return '<div class="alert alert-danger mt-3">Database connection failed.</div>';
    }

    // Get data from person table
    $bookingData = getBookingData();
    $new_datein = $bookingData['date_in'];
    $new_dateout = $bookingData['date_out'];
    $new_total = $bookingData['total_price'];

    // Build and execute SQL query
    $SQLcommand = "UPDATE booking 
               SET 
                   bkg_datein  = '$new_datein',
                   bkg_dateout     = '$new_dateout',
                   bkg_totalpr     = $new_total
               WHERE bkg_id = $book_id";

    echo $SQLcommand;

    if ($conn->query($SQLcommand) === TRUE) {
        $_SESSION['book_id']        = $book_id;
        $_SESSION['bkg_datein']     = $new_datein;
        $_SESSION['bkg_dateout']  = $new_dateout;
        $_SESSION['bkg_totalpr'] = $new_total;

        // Set a success message
        return '<div class="alert alert-success d-flex align-items-center w-100" role="alert">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round-check-icon lucide-user-round-check"><path d="M2 21a8 8 0 0 1 13.292-6"/><circle cx="10" cy="8" r="5"/><path d="m16 19 2 2 4-4"/></svg>
                                        <div class="ms-3">
                                            Room edited successfully!
                                        </div>
                                    </div>';
    } else {
        return '<div class="alert alert-danger d-flex align-items-center w-100" role="alert">
                    <   svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-circle-x me-2"><circle cx="12" cy="12" r="10"/>
                        <path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
                    <div>Something went wrong. Please try again.</div>
                </div>';
    }
}
