<?php

# Load environment variables from .env file if present in root directory
# Makes getDbConfig() work for dev to connect to remote db
if (file_exists('.env')) {
    $lines = file('.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    # Parse JAWSDB_MARIA_URL
    list($name, $value) = explode('=', $lines[0], 2);
    putenv(trim($name) . "=" . trim($value));
}

# Redirect to home page to avoid file referencing issues
header("Location: pages/home.php");
