<?php

$host = $_ENV["DB_HOST"];
$user = $_ENV["DB_USER"];
$password = $_ENV["DB_PASSWORD"];
$db_name = $_ENV["DB_NAME"];

$db = mysqli_connect($host, $user, $password, $db_name);


if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}
