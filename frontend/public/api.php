<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// For hosting
// require_once dirname(__DIR__) . '/backend/vendor/autoload.php';
// require_once dirname(__DIR__) . '/backend/src/config.php';

// For localhost
require_once dirname(__DIR__) . '/../backend/vendor/autoload.php';
require_once dirname(__DIR__) . '/../backend/src/config.php';

use Alexander\CityBike\Http\{Request, ErrorResponse};
use Alexander\CityBike\Exceptions\HttpException;
use Alexander\CityBike\Actions\Stations\{FindAllStations, FindStationById, CreateStation};
use Alexander\CityBike\Actions\Trips\{FindAllTrips, CreateTrip};
use Alexander\CityBike\Repositories\{StationsRepository, TripsRepository};

// CORS handling
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
    header('HTTP/1.1 200 OK');
    exit;
}

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

// Create a request object
$request = new Request($_GET, $_SERVER, file_get_contents('php://input'));

try {
    $path = $request->path();
} catch (HttpException) {
    (new ErrorResponse)->send();
    return;
}

try {
    $method = $request->method();
} catch (HttpException) {
    (new ErrorResponse)->send();
    return;
}

// Database connection
try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
} catch (PDOException $e) {
    throw new RuntimeException('Failed to connect to database: ' . $e->getMessage());
}

// Define routes
$routes = [
    'GET' => [
        '/api/stations/show' => new FindAllStations(new StationsRepository($pdo)),
        '/api/station/show' => new FindStationById(new StationsRepository($pdo)),
        '/api/trips/show' => new FindAllTrips(new TripsRepository($pdo)),
    ],
    'POST' => [
        '/api/stations/create' => new CreateStation(new StationsRepository($pdo)),
        '/api/trips/create' => new CreateTrip(new TripsRepository($pdo)),
    ]
];

// Handle requests
if (!array_key_exists($method, $routes)) {
    (new ErrorResponse('Not found'))->send();
    return;
}

if (!array_key_exists($path, $routes[$method])) {
    (new ErrorResponse('Not found'))->send();
    return;
}

$action = $routes[$method][$path];

try {
    $response = $action->handle($request);
} catch (Exception $e) {
    (new ErrorResponse($e->getMessage()))->send();
}

$response->send();