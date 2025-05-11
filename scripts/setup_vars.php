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
    # Define default database configuration
    $config = [
        //'servername' => 'localhost',
        'servername' => '127.0.0.1:3307',
        'username'   => 'root',
        'password'   => '',
        'dbname'     => 'docksidedb',
    ];

    # Use environment variables if they exist
    // if (getenv('DB_HOST')) $config['servername'] = getenv('DB_HOST');
    // if (getenv('DB_USERNAME')) $config['username'] = getenv('DB_USERNAME');
    // if (getenv('DB_PASSWORD')) $config['password'] = getenv('DB_PASSWORD');
    // if (getenv('DB_DATABASE')) $config['dbname'] = getenv('DB_DATABASE');

    return $config;
}


function isPersonSet()
{
    return (isset($_POST['fname'])) && (isset($_POST['lname'])) && (isset($_POST['address'])) && (isset($_POST['phone']))
        && (isset($_POST['birth'])) && (isset($_POST['email'])) && (isset($_POST['password']));
}
