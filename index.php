<?php

# Load environment variables from .env file if present in root directory
# Makes getDbConfig() work for dev to connect to remote db
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    # Parse JAWSDB_MARIA_URL
    if (strpos($line, '=') !== false) {
        list($name, $value) = explode('=', $line, 2);
        putenv(trim($name) . "=" . trim($value));
    }
}

# Redirect to home page to avoid file referencing issues
header("Location: pages/home.php");
