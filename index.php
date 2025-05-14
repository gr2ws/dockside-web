<?php

# Load environment variables from .env file if present in root directory
# Makes getDbConfig() work for dev and deployment on heroku
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        # Skip comments
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        # Parse key-value pairs
        if (strpos($line, '=') !== false) {
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            putenv("$name=$value");
        }
    }
}

# Redirect to home page to avoid file referencing issues

header("Location: pages/home.php");
