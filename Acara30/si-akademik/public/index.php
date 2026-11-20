<?php
require_once __DIR__ . '/../app/config/app.php';

header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
$allowedOrigin = getenv('CORS_ALLOWED_ORIGIN');
if (defined('APP_ENV') && APP_ENV !== 'production') {
    header('Access-Control-Allow-Origin: *');
} elseif ($allowedOrigin && $origin === $allowedOrigin) {
    header('Access-Control-Allow-Origin: ' . $allowedOrigin);
    header('Vary: Origin');
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

require_once __DIR__ . '/../app/core/autoload.php';

(new Router())->dispatch();
