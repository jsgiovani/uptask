<?php

namespace Controllers;

use MVC\Router;
use Classes\Email;
use Model\Usuario;

class LoginController
{
    public static function login(Router $router)
    {

        $alertas = array();

        $auth = new Usuario;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarFormulario();
            if (empty($alertas)) {
                $usuario = Usuario::where("usuario_email", $auth->usuario_email);


                if (!empty($usuario)) {
                    $alertas = $usuario->validarPasswordYConfirmado($auth->usuario_password);

                    if (empty($alertas)) {
                        session_start();
                        $_SESSION["login"] = true;
                        $_SESSION["nombre"] = $usuario->usuario_nombre;
                        $_SESSION["id"] = $usuario->usuario_id;
                        header("Location:/dashboard");
                    }
                } else {
                    Usuario::setAlerta("error", "El usuario no existe");
                }
            }else {
                $alertas = Usuario::getAlertas();
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/login', array(
            "alertas" => $alertas,
            "titulo" => "Login"
        ));
    }


    public static function crear(Router $router)
    {
        $alertas = array();
        $usuario = new Usuario;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuario->sincronizar($_POST);
            $usuario->validarNuevoRegistro();
            $usuario->validarPassword($_POST["usuario_password2"]);
            $alertas = Usuario::getAlertas();

            if (empty($alertas)) {
                $buscarUsuario = Usuario::where("usuario_email", $_POST["usuario_email"]);
                if ($buscarUsuario) {
                    $usuario->validarExistente();
                    $alertas = Usuario::getAlertas();
                } else {
                    $usuario->passwordHash();
                    $usuario->generarToken();
                    $email = new Email($usuario->usuario_email, $usuario->usuario_nombre, $usuario->usuario_token);
                    $email->enviarConfirmacion();
                    $respuesta = $usuario->crear();
                    if ($respuesta) {
                        header("Location:/mensaje");
                    }
                }
            }
        }

        $router->render('auth/crear', array(
            "alertas" => $alertas,
            "titulo" => "Registro",
            "usuario" => $usuario
        ));
    }


    public static function olvide(Router $router)
    {

        $alertas = array();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if (empty($alertas)) {
                $usuario = Usuario::where("usuario_email", $auth->usuario_email);
                if ($usuario) {
                    $alertas = $usuario->estaConfirmado();
                    if (empty($alertas)) {
                        $usuario->usuario_token = null;
                        $usuario->generarToken();
                        $email = new Email($usuario->usuario_email, $usuario->usuario_nombre, $usuario->usuario_token);
                        $email->enviarInstrucciones();
                        $resultado = $usuario->actualizar();
                        if ($resultado) {
                            header("Location:/mensaje");
                        }
                    } else {
                        Usuario::getAlertas();
                    }
                } else {
                    Usuario::setAlerta("error", "El usuario no existe o no ha sido validado");
                }
            } else {
                $alertas = Usuario::getAlertas();
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/olvide', array(
            "alertas" => $alertas,
            "titulo" => "Olvide mi password"
        ));
    }


    public static function restablecer(Router $router)
    {
        $alertas = array();
        $mostrar = false;
        $token = s($_GET["token"]) ?? null;

        if ($token) {
            if ((strlen($token) === 13)) {
                $usuario = Usuario::where("usuario_token", $token);
                if (!empty($usuario)) {
                    $mostrar = true;
                } else {
                    Usuario::setAlerta("error", "Token invalido");
                }
            } else {
                Usuario::setAlerta("error", "Token invalido");
            }
        } else {
            header("location:/");
        }


        $alertas = Usuario::getAlertas();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!empty($usuario)) {

                $usuario->sincronizar($_POST);
                $usuario->validarPasswordReset();
                $alertas = Usuario::getAlertas();
                if (empty($alertas)) {
                    $usuario->passwordHash();
                    $usuario->usuario_token = null;
                    $resultado = $usuario->actualizar();
                    deb($resultado);

                    if ($resultado === true) {
                        header("Location:/confirmar");
                    }
                } else {
                    $alertas = Usuario::getAlertas();
                }
            }
        }

        $router->render('auth/restablecer', array(
            "alertas" => $alertas,
            "titulo" => "Restablecer password",
            "mostrar" => $mostrar
        ));
    }




    public static function mensaje(Router $router)
    {
        $alertas = array();


        $router->render('auth/mensaje', array(
            "alertas" => $alertas,
            "titulo" => "Cuenta creada exitosamente"
        ));
    }


    public static function confirmar(Router $router)
    {
        $alertas = array();
        $token = s($_GET["token"]) ?? null;
        $error = true;
        if ($token) {

            $usuario = Usuario::where("usuario_token", $token);
            if (!empty($usuario)) {
                $error = false;
                $usuario->usuario_token = null;
                $usuario->usuario_confirmado = 1;
                $respuesta = $usuario->actualizar();
                if ($respuesta) {
                    Usuario::setAlerta("exito", "Cuenta validada exitosamente");
                }
            } else {
                Usuario::setAlerta("error", "Token invalido");
            }
        } else {
            //token no valido
            header("location:/");
        }



        $alertas = Usuario::getAlertas();



        $router->render('auth/confirmar', array(
            "alertas" => $alertas,
            "titulo" => "Confirmar cuenta",
            "error" => $error
        ));
    }


    public static function logout()
    {
       session_start();
       session_destroy();
       

       header("Location:/");
    }
}
