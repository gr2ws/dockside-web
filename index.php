<?php

# Load environment variables from .env file
function loadEnv($path)
{
    if (!file_exists($path)) {
        return false;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
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

    return true;
}

# Execute the function to load environment variables
loadEnv(__DIR__ . '/.env');

# redirect to home page to avoid file referencing issues

header("Location: pages/home.php");
