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
    // Define default database configuration
    $config = [
        //'servername' => 'localhost',
        'servername' => '127.0.0.1:3307',
        'username'   => 'root',
        'password'   => '',
        'dbname'     => 'docksidedb',
    ];

    // Check if .env file exists
    if (file_exists(__DIR__ . '/../.env')) {
        // Parse the .env file
        $env = [];
        $lines = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        // Process each line in the .env file
        foreach ($lines as $line) {
            // Skip comments (lines starting with #)
            if (strpos(trim($line), '#') === 0) continue;

            // Parse key-value pairs
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $env[trim($key)] = trim($value);
            }
        }

        // Override default settings with environment variables if they exist
        if (!empty($env['DB_HOST'])) $config['servername'] = $env['DB_HOST'];
        if (!empty($env['DB_USERNAME'])) $config['username'] = $env['DB_USERNAME'];
        if (!empty($env['DB_PASSWORD'])) $config['password'] = $env['DB_PASSWORD'];
        if (!empty($env['DB_DATABASE'])) $config['dbname'] = $env['DB_DATABASE'];
    }

    return $config;
}

function isPersonSet()
{
    return (isset($_POST['fname'])) && (isset($_POST['lname'])) && (isset($_POST['address'])) && (isset($_POST['phone']))
        && (isset($_POST['birth'])) && (isset($_POST['email'])) && (isset($_POST['password']));
}
