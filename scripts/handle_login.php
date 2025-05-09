<?php

function handleNewAcc()
{
    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // initializing variables for conditional form population
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $birthday = $_POST['birth'];
        $email = $_POST['email'];
        $pass = $_POST['password'];

        //$servername = "127.0.0.1:3307";
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "docksidedb";

        // double-check form population by user (though, 'required' is already set in HTML)
        if ((isset($_POST['fname'])) && (isset($_POST['lname'])) && (isset($_POST['address'])) && (isset($_POST['phone']))
            && (isset($_POST['birth'])) && (isset($_POST['email'])) && (isset($_POST['password']))
        ) {
            $conn = new mysqli($servername, $username, $password, $dbname);

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
                echo     '<div class="alert alert-danger d-flex align-items-center mt-4 mb-n2 w-50" role="alert">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x-icon lucide-circle-x"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>	
								<div class = "ms-3">
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
                    // Account created successfully, clear all fields
                    unset($_POST['fname']);
                    unset($_POST['lname']);
                    unset($_POST['email']);
                    unset($_POST['password']);
                    unset($_POST['address']);
                    unset($_POST['phone']);
                    unset($_POST['birth']);
                    echo     '<div class="alert alert-success d-flex align-items-center mt-4 mb-n2 w-50" role="alert">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round-check-icon lucide-user-round-check"><path d="M2 21a8 8 0 0 1 13.292-6"/><circle cx="10" cy="8" r="5"/><path d="m16 19 2 2 4-4"/></svg>									
									<div class = "ms-3">	
										User account created successfully!
									</div>
								</div>';
                } else {
                    echo '<div class="alert alert-danger d-flex align-items-center mt-4 mb-n2 w-50" role="alert">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x-icon lucide-circle-x"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>	
								<div class = "ms-3">'
                        . $conn->error .
                        '</div>
							</div>';
                }
            }
        }
    }
}
