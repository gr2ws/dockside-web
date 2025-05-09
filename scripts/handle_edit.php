<?php

require_once __DIR__ . '/setup_vars.php';

function handleEdit($id)
{
    // get db config data
    $dbConfig  = getDbConfig();
    $servername = $dbConfig['servername'];
    $username   = $dbConfig['username'];
    $password   = $dbConfig['password'];
    $dbname     = $dbConfig['dbname'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        return '<div class="alert alert-danger mt-3">Database connection failed.</div>';
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        //get data from person table
        $personData = getPersonData();
        $fname     = $personData['fname'];
        $lname     = $personData['lname'];
        $address   = $personData['address'];
        $phone     = $personData['phone'];
        $birth     = $personData['birthday'];

        $SQLcommand =  "UPDATE person 
                        SET 
                            pers_fname = '$fname',
                            pers_lname = '$lname',
                            pers_address = '$address',
                            pers_number = '$phone',
                            pers_birthdate = '$birth'
                        WHERE pers_id = $id";

        if ($conn->query($SQLcommand) === TRUE) {
            echo    '<div class="alert alert-success d-flex align-items-center mt-4 mb-n2 w-50" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round-check-icon lucide-user-round-check"><path d="M2 21a8 8 0 0 1 13.292-6"/><circle cx="10" cy="8" r="5"/><path d="m16 19 2 2 4-4"/></svg>									
                        <div class = "ms-3">	
                            User profile edited successfully!
                        </div>
                    </div>';
        } else {
            return '<div class="alert alert-danger d-flex align-items-center mt-4 w-50" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-circle-x me-2"><circle cx="12" cy="12" r="10"/>
                        <path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
                    <div>Incorrect email or password. Please try again.</div>
                </div>';
        }
    }
}
