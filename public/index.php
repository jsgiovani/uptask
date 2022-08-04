<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\LoginController;
use Controllers\TareaController;
use Controllers\DashboardController;
$router = new Router();

//login
$router->get("", [LoginController::class, "login"]);
$router->post("", [LoginController::class, "login"]);

//logout
$router->get("logout", [LoginController::class, "logout"]);


//crear nueva cuenta
$router->get("crear", [LoginController::class, "crear"]);
$router->post("crear", [LoginController::class, "crear"]);


//crear nueva cuenta
$router->get("crear", [LoginController::class, "crear"]);
$router->post("crear", [LoginController::class, "crear"]);


//formulario para insertar email para solicitar restablecer pasword
$router->get("olvide", [LoginController::class, "olvide"]);
$router->post("olvide", [LoginController::class, "olvide"]);


//formulario para restablecer pasword
$router->get("restablecer", [LoginController::class, "restablecer"]);
$router->post("restablecer", [LoginController::class, "restablecer"]);


//mostrar mensaje de confirmacion
$router->get("mensaje", [LoginController::class, "mensaje"]);

//confirma los tokens para validarcion de cuenta o restablecer password
$router->get("confirmar", [LoginController::class, "confirmar"]);


//ZONA DE PROYECTOS
$router->get("dashboard", [DashboardController::class, "index"]);

//nuevo proyecto
$router->get("crear-proyecto", [DashboardController::class, "crear_proyecto"]);
$router->post("crear-proyecto", [DashboardController::class, "crear_proyecto"]);


//mostar un proyecto
$router->get("proyecto", [DashboardController::class, "proyecto"]);


//API para las tareas
$router->get("api/tareas", [TareaController::class, "obtener"]);
$router->post("api/tareas", [TareaController::class, "crear"]);
$router->post("api/tareas/actualizar", [TareaController::class, "actualizar"]);
$router->post("api/tareas/eliminar", [TareaController::class, "eliminar"]);


//nuevo editar perfil
$router->get("perfil", [DashboardController::class, "perfil"]);
$router->post("perfil", [DashboardController::class, "perfil"]);


//cambiar password
$router->get("cambiar-password", [DashboardController::class, "cambiar_password"]);
$router->post("cambiar-password", [DashboardController::class, "cambiar_password"]);



// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();