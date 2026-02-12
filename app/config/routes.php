<?php
use app\controllers\ApiController;
Flight::route('GET /', [ApiController::class, 'showLogin']);
Flight::route('GET /login', [ApiController::class, 'showLogin']);
Flight::route('POST /login', [ApiController::class, 'loginPost']);
Flight::route('POST /dashboard', [ApiController::class, 'showDashboard']);
Flight::route('GET /dashboard', [ApiController::class, 'showDashboard']);

Flight::route('GET /logout', function() {
    session_start();
    session_destroy();
    Flight::redirect('/login');
});
?>