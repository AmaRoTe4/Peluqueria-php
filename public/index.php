<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\LoginController;

$router = new Router();

$router->get("/login" , [LoginController::class, "login"]);
$router->get("/forgot" , [LoginController::class, "forgot"]);
$router->get("/logout" , [LoginController::class, "logout"]);
$router->get("/recover" , [LoginController::class, "recover"]);
$router->get("/create" , [LoginController::class, "create"]);
$router->get("/confirmar" , [LoginController::class, "confirmar"]);
$router->get("/mensaje" , [LoginController::class, "mensaje"]);

$router->post("/login" , [LoginController::class, "login"]);
$router->post("/forgot" , [LoginController::class, "forgot"]);
$router->post("/recover" , [LoginController::class, "recover"]);
$router->post("/create" , [LoginController::class, "create"]);

$router->comprobarRutas();