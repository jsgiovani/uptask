<?php

namespace Controllers;

use MVC\Router;
use Model\Proyecto;
use Model\Usuario;

class DashboardController
{
    public static function index(Router $router)
    {
        session_start();
        isAuth();
        
        $nombre = $_SESSION["nombre"];
        $id = $_SESSION["id"];
        $proyectos = Proyecto::belongsTo("proyecto_propietarioId", $id);
        $router->render('dashboard/index', [
            "nombre" => $nombre,
            "titulo" => "Dashboard",
            "proyectos" => $proyectos
        ]);
    }


    public static function crear_proyecto(Router $router)
    {
        session_start();
        isAuth();
        $nombre = $_SESSION["nombre"];
        $id = $_SESSION["id"];
        $alertas = array();


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_POST["proyecto_propietarioId"] = $id;
            $proyecto = new Proyecto($_POST);
            $alertas = $proyecto->validarNombre();

            if (empty($alertas)) {
                $hash = md5(uniqid());
                $proyecto->proyecto_url = $hash;
                $respuesta = $proyecto->crear();

                if ($respuesta) {
                    header("Location:/proyecto?proyecto_url=" . $proyecto->proyecto_url);
                }
            } else {
                $alertas = $proyecto->getAlertas();
            }
        }

        $alertas = Proyecto::getAlertas();
        $router->render('dashboard/crear-proyecto', [
            "nombre" => $nombre,
            "titulo" => "Nuevo proyecto",
            "alertas" => $alertas,
            "usuario_id" => $id

        ]);
    }


    public static function proyecto(Router $router)
    {
        session_start();
        isAuth();
        $nombre = $_SESSION["nombre"];
        $id = $_SESSION["id"];

        $proyecto_url = $_GET["proyecto_url"] ?? null;
        if ($proyecto_url) {
            $proyecto = Proyecto::where("proyecto_url", $proyecto_url);
            if (!empty($proyecto)) {
                if ($proyecto->proyecto_propietarioId == $id) {
                }else {
                    header("Location:/dashboard");
                }
            }else {
                
            }
        }else {
            header("Location:/dashboard");
        }

        $router->render('dashboard/proyecto', [
            "nombre" => $nombre,
            "titulo" => $proyecto->proyecto_nombre,
            "proyectos" => array()
        ]); 
    }


    public static function perfil(Router $router){
        session_start();
        isAuth();

        $id = $_SESSION["id"];
        $alertas = array();
        $usuario = Usuario::find($id);
        
        if ($_SERVER["REQUEST_METHOD"] == "POST")  {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->actualizar_usuario();
            if (empty($alertas)) {
              $actualizar  = $usuario->actualizar();
              if (!empty($actualizar)) {
                Usuario::setAlerta("exito", "Datos actualizados correctamente");
                $_SESSION["nombre"] = $usuario->usuario_nombre;

              }
            }
            
        }

        $alertas = Usuario::getAlertas();


        $router->render('dashboard/perfil', [
            "usuario" => $usuario,
            "titulo" => "Perfil",
            "alertas" => $alertas
        ]); 

    }



    public static function cambiar_password(Router $router){
        session_start();
        isAuth();

        $id = $_SESSION["id"];
        $alertas = array();
        $usuario = Usuario::find($id);
        
        if ($_SERVER["REQUEST_METHOD"] == "POST")  {
            $auth = new Usuario($_POST);
            //deb($auth);
            //deb($_POST);
            $alertas = $usuario->validarCambioDePassword($auth->usuario_password, $_POST["password_nuevo"]);
            
            if (empty($alertas)) {
                $usuario->usuario_password = $_POST["password_nuevo"];
                $usuario->passwordHash();
                $actualizar  = $usuario->actualizar();

              if (!empty($actualizar)) {
                Usuario::setAlerta("exito", "Password cambiado correctamente");

              }
            }else{
                $alertas = Usuario::getAlertas();
            }
            
        }

        $alertas = Usuario::getAlertas();


        $router->render('dashboard/cambiar-password', [
            "usuario" => $usuario,
            "titulo" => "Perfil",
            "alertas" => $alertas
        ]); 

    }
}
