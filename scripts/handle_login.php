<?php

require_once __DIR__ . '/setup_vars.php';


function handleLogin()
{
    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        //get data from person table
        $personData = getPersonData();
        $email     = $personData['email'];
        $pass      = $personData['pass'];

        // get db config data
        $dbConfig  = getDbConfig();
        $servername = $dbConfig['servername'];
        $username   = $dbConfig['username'];
        $dbpassword = $dbConfig['password'];
        $dbname     = $dbConfig['dbname'];


        $conn = new mysqli($servername, $username, $dbpassword, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $SQLcommand = "SELECT COUNT(*) AS instanceCount FROM $dbname.`person` WHERE 
                pers_email = '$email' AND pers_pass = '$pass'";

        $result = $conn->query($SQLcommand); // Execute the query

        if ($result) {
            // take a row where email and password match what the user has entered.
            $doesExist = $result->fetch_assoc();

            if ($doesExist['instanceCount'] != 0) {
                header("Location: ../pages/user_dashboard.php");
                exit;
            } else {
                // invalid creds, return to login
                return '<div class="alert alert-danger d-flex align-items-center mt-4 mb-n2 w-50" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x-icon lucide-circle-x">
                            <circle cx="12" cy="12" r="10" />
                            <path d="m15 9-6 6" />
                            <path d="m9 9 6 6" />
                        </svg>
                        <div class="ms-3">
                            Incorrect username or password. Please try again.
                        </div>
                    </div>'; //error message
                exit;
            }
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
