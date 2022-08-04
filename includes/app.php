<?php 
// Conectarnos a la base de datos

use Model\ActiveRecord;
use Dotenv\Dotenv;


require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv::createImmutable(__DIR__);

$dotenv->safeLoad();

require 'funciones.php';
require 'database.php';




ActiveRecord::setDB($db);