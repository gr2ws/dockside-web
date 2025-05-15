<?php

require_once __DIR__ . '/setup_vars.php';

function handleNewAcc($redirect = '')
{
    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Check for redirect parameter from form
        if (empty($redirect) && isset($_POST['redirect'])) {
            $redirect = $_POST['redirect'];
        }

        //get data from person table
        $personData = getPersonData();
        $fname     = $personData['fname'];
        $lname     = $personData['lname'];
        $address   = $personData['address'];
        $phone     = $personData['phone'];
        $birthday  = $personData['birthday'];
        $email     = $personData['email'];
        $pass      = $personData['pass'];

        // get db config data
        $dbConfig  = getDbConfig();
        $servername = $dbConfig['servername'];
        $username   = $dbConfig['username'];
        $dbpassword = $dbConfig['password'];
        $dbname     = $dbConfig['dbname'];

        // double-check form population by user (though, 'required' is already set in HTML)
        if (isPersonSet()) {
            $conn = new mysqli($servername, $username, $dbpassword, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Check if email already exists
            $email = $_POST['email'];
            $exec_SQLCommand = $conn->query("SELECT COUNT(*) AS instanceCount FROM $dbname.`person` WHERE pers_email = '$email'");
            $doesExist = $exec_SQLCommand->fetch_assoc();

            if ($doesExist['instanceCount'] != 0) {
                // Email already exists, clear email and password fields only
                unset($_POST['email']);
                unset($_POST['password']);
                echo '<div class="alert alert-danger d-flex align-items-center mt-4 mb-n2 w-50" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x-icon lucide-circle-x">
                            <circle cx="12" cy="12" r="10" />
                            <path d="m15 9-6 6" />
                            <path d="m9 9 6 6" />
                        </svg>
                        <div class="ms-3">
                            Email already in use. Please try another.
                        </div>
                    </div>'; //error message
            } else {
                // Email does not exist, create account
                $result = $conn->query("SELECT MAX(pers_id) AS max_id FROM person");
                $row = $result->fetch_assoc(); // get hard integer value from executing SQL query above
                $nextId = $row['max_id'] + 1;
                $conn->query("ALTER TABLE person AUTO_INCREMENT = $nextId");

                $SQLcommand = "INSERT INTO $dbname.`person`
                                (pers_fname, pers_lname, pers_address, pers_number, pers_birthdate, pers_email, pers_pass) VALUES
                                ('$fname', '$lname', '$address', '$phone', '$birthday', '$email', '$pass')";
                if ($conn->query($SQLcommand) === TRUE) {
                    // Account created successfully

                    // Get the user data for login
                    $result = $conn->query("SELECT * FROM person WHERE pers_email = '$email'");
                    if ($result && $result->num_rows > 0) {
                        $user = $result->fetch_assoc();

                        // Store user info in session
                        $_SESSION['id']       = $user['pers_id'];
                        $_SESSION['fname']    = $user['pers_fname'];
                        $_SESSION['lname']    = $user['pers_lname'];
                        $_SESSION['address']  = $user['pers_address'];
                        $_SESSION['phone']    = $user['pers_number'];
                        $_SESSION['birthday'] = $user['pers_birthdate'];
                        $_SESSION['email']    = $user['pers_email'];
                        $_SESSION['pass']     = $user['pers_pass'];
                        $_SESSION['role']     = $user['pers_role'];                        // Redirect if specified
                        if (!empty($redirect)) {
                            header("Location: ../" . ltrim($redirect, '/'));
                            exit;
                        } else {
                            // Default redirect to user dashboard if no redirect parameter
                            header("Location: ../pages/user_dashboard.php");
                            exit;
                        }
                    }

                    // These fields are cleared if no redirection happens (should not be reached now)
                    unset($_POST['fname']);
                    unset($_POST['lname']);
                    unset($_POST['email']);
                    unset($_POST['password']);
                    unset($_POST['address']);
                    unset($_POST['phone']);
                    unset($_POST['birth']);
                    echo '<div class="alert alert-success d-flex align-items-center mt-4 mb-n2 w-50" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round-check-icon lucide-user-round-check">
                                <path d="M2 21a8 8 0 0 1 13.292-6" />
                                <circle cx="10" cy="8" r="5" />
                                <path d="m16 19 2 2 4-4" />
                            </svg>
                            <div class="ms-3">
                                User account created successfully!
                            </div>
                        </div>';
                } else {
                    echo '<div class="alert alert-danger d-flex align-items-center mt-4 mb-n2 w-50" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x-icon lucide-circle-x">
                                <circle cx="12" cy="12" r="10" />
                                <path d="m15 9-6 6" />
                                <path d="m9 9 6 6" />
                            </svg>
                            <div class="ms-3">'
                        . $conn->error .
                        '</div>
</div>';
                }
            }
        }
    }
}
