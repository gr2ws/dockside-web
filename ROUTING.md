# Dockside Hotel Website Routing Implementation Guide

_\*ai generated, for future reference_

This guide outlines how to implement a clean routing system for the Dockside Hotel website using a combination of a Router class and .htaccess file.

## Implementation Steps

### 1. Create the Router Class

Create a new directory `router` in your project root and add a `Router.php` file:

```php
<?php
class Router
{
    private $routes = [];

    /**
     * Add a route to the routing table
     * @param string $uri The route URI
     * @param string $filePath The file path to load for this route
     * @return Router
     */
    public function add($uri, $filePath) {
        $this->routes[$uri] = $filePath;
        return $this;
    }

    /**
     * Dispatch the route
     * @param string $uri The route URI
     * @return bool True if the route is found, false otherwise
     */
    public function dispatch($uri) {
        if (array_key_exists($uri, $this->routes)) {
            require BASE_PATH . '/' . $this->routes[$uri];
            return true;
        }
        return false;
    }
}
```

### 2. Create a 404 Error Page

Create a `404.php` file in your pages directory:

```php
<?php require_once 'common.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found - Dockside Hotel</title>
    <link rel="stylesheet" href="/styles/global.css">
    <!-- Add any additional styles -->
</head>
<body>
    <?php include BASE_PATH . '/components/header.html'; ?>

    <main>
        <h1>404 - Page Not Found</h1>
        <p>Sorry, the page you are looking for does not exist.</p>
        <a href="/">Return to Homepage</a>
    </main>

    <?php include BASE_PATH . '/components/footer.html'; ?>
</body>
</html>
```

### 3. Update index.php to Use the Router

Replace the content of your existing `index.php` with:

```php
<?php
define('BASE_PATH', __DIR__);
require_once BASE_PATH . '/router/Router.php';

// Get the request URI and remove any query string
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// For local development, remove the base directory from URI
// Uncomment and adjust this line for local development with XAMPP
// $uri = str_replace('/dockside-web', '', $uri);

// Create router instance
$router = new Router();

// Define routes
$router->add('/', 'pages/home.php')
       ->add('/login', 'pages/login.php')
       ->add('/signup', 'pages/signUp.php')
       ->add('/terms', 'pages/terms.php')
       ->add('/privacy', 'pages/privacy.php')
       ->add('/aboutus', 'pages/aboutus.php');

// Add additional routes as needed
// $router->add('/rooms', 'pages/rooms.php');
// $router->add('/contact', 'pages/contact.php');

// Dispatch route or show 404
if (!$router->dispatch($uri)) {
    header('HTTP/1.0 404 Not Found');
    require BASE_PATH . '/pages/404.php';
}
```

### 4. Create .htaccess File

Create a `.htaccess` file in your project root:

#### For Local Development (XAMPP)

```apache
RewriteEngine On
RewriteBase /dockside-web/

# Don't rewrite files or directories
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d

# Rewrite everything else to index.php
RewriteRule ^(.*)$ index.php [L,QSA]
```

#### For Heroku Deployment

```apache
RewriteEngine On
RewriteBase /

# Don't rewrite files or directories
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d

# Rewrite everything else to index.php
RewriteRule ^(.*)$ index.php [L,QSA]
```

### 5. Update Resource References

You'll need to update how you reference your CSS, JS, and image files in your HTML to use absolute paths:

Instead of:

```html
<link rel="stylesheet" href="styles/global.css" />
```

Use:

```html
<link rel="stylesheet" href="/styles/global.css" />
```

Or for local development with the base path:

```html
<link rel="stylesheet" href="/dockside-web/styles/global.css" />
```

Better yet, create a `BASE_URL` constant and use that:

```php
<?php
// In common.php
define('BASE_URL', '/dockside-web'); // For local development
// define('BASE_URL', ''); // For production
?>

<!-- In HTML -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/styles/global.css">
```

### 6. For Heroku Deployment

Create a `Procfile` in your project root:

```
web: vendor/bin/heroku-php-apache2 ./
```

Create a minimal `composer.json` file:

```json
{
	"require": {
		"php": "^8.0"
	},
	"require-dev": {}
}
```

## Configuration Switch Between Local and Production

To make it easy to switch between local development and production, you can use environment variables or a configuration file. Here's a simple approach:

Create a `config.php` file:

```php
<?php
// Detect environment
$isProduction = (getenv('ENVIRONMENT') === 'production' || file_exists(__DIR__ . '/.production'));

// Base configuration
define('BASE_PATH', __DIR__);
define('BASE_URL', $isProduction ? '' : '/dockside-web');

// Other configuration options
define('DEBUG', !$isProduction);
```

Then include this at the top of your `index.php`:

```php
<?php
require_once __DIR__ . '/config.php';
require_once BASE_PATH . '/router/Router.php';

// Rest of your routing code...
```

## Benefits of this Approach

1. **Clean URLs**: Users see `/login` instead of `pages/login.php`
2. **Centralized Routing**: All routes defined in one place
3. **Flexibility**: Easy to change routes without affecting code
4. **Separation of Concerns**: URL structure separate from file structure
5. **Security**: File structure hidden from users
6. **SEO Benefits**: Search engines prefer clean URLs

## Next Steps for Enhanced Routing

Once the basic routing is in place, you could consider these enhancements:

1. **Dynamic parameters**: Support for URL parameters like `/room/{id}`
2. **Middleware support**: Add authentication, logging, or other pre/post processing
3. **Named routes**: For easier URL generation
4. **HTTP method constraints**: Limit routes to specific HTTP methods (GET, POST, etc.)

Remember to adjust paths in your components and includes to work with the new routing system.

## Implementing GET/POST Request Handling

To handle different HTTP methods (GET, POST, etc.) in your routing system, you can enhance the Router class to support method-specific routes. This is useful for forms, API endpoints, and other features that use different HTTP methods.

### 1. Enhanced Router Class with HTTP Method Support

Update your `Router.php` file to include HTTP method support:

```php
<?php
class Router
{
    private $routes = [];

    /**
     * Add a route to the routing table
     * @param string $method The HTTP method (GET, POST, etc.)
     * @param string $uri The route URI
     * @param string $filePath The file path to load for this route
     * @return Router
     */
    public function add($method, $uri, $filePath) {
        $this->routes[$method][$uri] = $filePath;
        return $this;
    }

    /**
     * Add a GET route
     * @param string $uri The route URI
     * @param string $filePath The file path to load for this route
     * @return Router
     */
    public function get($uri, $filePath) {
        return $this->add('GET', $uri, $filePath);
    }

    /**
     * Add a POST route
     * @param string $uri The route URI
     * @param string $filePath The file path to load for this route
     * @return Router
     */
    public function post($uri, $filePath) {
        return $this->add('POST', $uri, $filePath);
    }

    /**
     * Add a route that responds to any method
     * @param string $uri The route URI
     * @param string $filePath The file path to load for this route
     * @return Router
     */
    public function any($uri, $filePath) {
        $this->get($uri, $filePath);
        $this->post($uri, $filePath);
        return $this;
    }

    /**
     * Dispatch the route
     * @param string $method The HTTP method
     * @param string $uri The route URI
     * @return bool True if the route is found, false otherwise
     */
    public function dispatch($method, $uri) {
        // First check for method-specific route
        if (isset($this->routes[$method][$uri])) {
            require BASE_PATH . '/' . $this->routes[$method][$uri];
            return true;
        }

        return false;
    }
}
```

### 2. Update index.php to Use the Enhanced Router

```php
<?php
define('BASE_PATH', __DIR__);
require_once BASE_PATH . '/router/Router.php';

// Get the request URI and remove any query string
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD']; // Get HTTP method (GET, POST, etc.)

// For local development, remove the base directory from URI
// Uncomment and adjust this line for local development with XAMPP
// $uri = str_replace('/dockside-web', '', $uri);

// Create router instance
$router = new Router();

// Define routes with HTTP methods
$router->get('/', 'pages/home.php')
       ->get('/login', 'pages/login.php')
       ->get('/signup', 'pages/signUp.php')
       ->get('/terms', 'pages/terms.php')
       ->get('/privacy', 'pages/privacy.php')
       ->get('/aboutus', 'pages/aboutus.php');

// Add POST routes for form handling
$router->post('/login', 'scripts/process_login.php')
       ->post('/signup', 'scripts/process_newacc.php');

// Routes that work with both GET and POST
// $router->any('/contact', 'pages/contact.php');

// Dispatch route or show 404
if (!$router->dispatch($method, $uri)) {
    header('HTTP/1.0 404 Not Found');
    require BASE_PATH . '/pages/404.php';
}
```

### 3. Using Form Actions with the Router

Update your HTML forms to use the correct action URLs:

```html
<!-- Old form with direct PHP script reference -->
<form method="post" action="scripts/process_login.php">
	<!-- New form using router path -->
	<form method="post" action="<?php echo BASE_URL; ?>/login"></form>
</form>
```

### 4. Handling Form Data in Route Handlers

In your route handler files (e.g., `scripts/process_login.php`), you can access form data as usual:

```php
<?php
// This file is accessed through the router when POST /login is requested

// Access form data
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Process login
if (/* validate login credentials */) {
    // Start session, set cookies, etc.
    $_SESSION['user'] = $email;

    // Redirect to dashboard or home page
    header("Location: " . BASE_URL . "/");
    exit;
} else {
    // Redirect back to login with error
    header("Location: " . BASE_URL . "/login?error=invalid");
    exit;
}
```

### 5. API Endpoints Example

For creating API endpoints that return JSON:

```php
<?php
// Router definition in index.php
$router->post('/api/book-room', 'api/book_room.php');

// api/book_room.php
header('Content-Type: application/json');

$room_id = $_POST['room_id'] ?? null;
$check_in = $_POST['check_in'] ?? null;
$check_out = $_POST['check_out'] ?? null;

// Process the booking
$result = /* booking logic */;

if ($result) {
    echo json_encode(['success' => true, 'booking_id' => $result]);
} else {
    echo json_encode(['success' => false, 'message' => 'Booking failed']);
}
```

### 6. Advanced: Using Route Parameters

For dynamic routes with parameters (e.g., `/room/123`), you can enhance the Router:

```php
<?php
class Router
{
    // Existing code...

    /**
     * Extract parameters from a URI based on a pattern
     * @param string $pattern The route pattern with placeholders
     * @param string $uri The actual URI
     * @return array|null Parameters or null if no match
     */
    private function extractParams($pattern, $uri) {
        // Convert the pattern to a regular expression
        $patternRegex = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $pattern);
        $patternRegex = '#^' . $patternRegex . '$#';

        if (preg_match($patternRegex, $uri, $matches)) {
            // Remove numeric keys
            foreach ($matches as $key => $value) {
                if (is_int($key)) {
                    unset($matches[$key]);
                }
            }
            return $matches;
        }

        return null;
    }

    /**
     * Dispatch the route with parameter support
     * @param string $method The HTTP method
     * @param string $uri The route URI
     * @return bool True if the route is found, false otherwise
     */
    public function dispatch($method, $uri) {
        // First check for exact match
        if (isset($this->routes[$method][$uri])) {
            require BASE_PATH . '/' . $this->routes[$method][$uri];
            return true;
        }

        // Check for pattern matches
        foreach ($this->routes[$method] ?? [] as $pattern => $file) {
            if (strpos($pattern, '{') !== false) {
                $params = $this->extractParams($pattern, $uri);
                if ($params) {
                    // Set parameters in $_GET
                    foreach ($params as $key => $value) {
                        $_GET[$key] = $value;
                    }
                    require BASE_PATH . '/' . $file;
                    return true;
                }
            }
        }

        return false;
    }
}
```

Then you can define dynamic routes:

```php
$router->get('/room/{id}', 'pages/room_detail.php');
```

And access parameters in the handler:

```php
// pages/room_detail.php
$room_id = $_GET['id'];
// Now fetch and display room details
```

This approach lets you build RESTful routes and handle dynamic content efficiently.
