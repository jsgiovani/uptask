<?php

namespace Model;

class Usuario extends ActiveRecord {
    protected static $tabla = "usuarios";
    protected static $llavePrimaria  = "usuario_id";
    protected static $columnasDB  = array("usuario_id", "usuario_nombre", "usuario_email", "usuario_password", "usuario_token", "usuario_confirmado");

    public $usuario_id;
    public $usuario_nombre;
    public $usuario_email;
    public $usuario_password;
    public $usuario_token;
    public $usuario_confirmado;

    public function __construct($args = array()){
        $this->usuario_id = $args['usuario_id'] ?? null;
        $this->usuario_nombre = $args['usuario_nombre'] ?? "";
        $this->usuario_email = $args['usuario_email'] ?? "";
        $this->usuario_password = $args['usuario_password'] ?? "";
        $this->usuario_token = $args['usuario_token'] ?? "";
        $this->usuario_confirmado = $args['usuario_confirmado'] ?? 0;
    }


    public function validarNuevoRegistro() {
        if (!$this->usuario_nombre) {
            self::$alertas["error"][] = "Ingrese su nombre";
        }

        if (!$this->usuario_email) {
            self::$alertas["error"][] = "Ingrese su email";
        }

        if (!$this->usuario_password && strlen($this->usuario_password) < 7) {
            self::$alertas["error"][] = "El password debe tener un minimo de 7 caracteres";
        }

        return self::$alertas;
    }


    public function validarPassword($password2) {
        if ($this->usuario_password !== $password2) {
            self::$alertas["error"][] = "Los passwords no coinciden";
            return self::$alertas;
        }
    }

    public function passwordHash() {
        $this->usuario_password = password_hash($this->usuario_password,PASSWORD_BCRYPT);
    }

    public function generarToken() {
        $this->usuario_token = uniqid($this->usuario_token);
    }


    public function validarExistente() {
        self::$alertas["error"][] = "El usuario ya esta registrado";
        return self::$alertas;
    }

    public function validarEmail() {
        if (!$this->usuario_email) {
            self::$alertas["error"][] = "Ingrese email";
            return self::$alertas;
        }
    }

    public function estaConfirmado() {
        if ($this->usuario_confirmado !== "1"){
            self::$alertas["error"][] = "El usuario no se ha confirmado, por favor revise su email";
            return self::$alertas;
        }
    }


    public function validarPasswordReset() {
        if (strlen($this->usuario_password) < 7){
            self::$alertas["error"][] = "Su password debe tener al menos 7 caracteres";
            return self::$alertas;
        }
    }


    public function validarPasswordYConfirmado($password) {
        $verify_password = password_verify($password, $this->usuario_password);

       
        if (!$verify_password || $this->usuario_confirmado !== "1" ) {
            self::$alertas["error"][] = "El password es incorrecto o la cuenta no ha sido verificada";
            return self::$alertas;
        }

    }
    

    public function validarFormulario() {
        if ( ! $this->usuario_email ) {
            self::$alertas["error"][] = "Ingrese su email";
        }

        if ( ! $this->usuario_password ) {
            self::$alertas["error"][] = "Ingrese su password";
        }

        return self::$alertas;
    }


    public function actualizar_usuario() {
        if (!$this->usuario_nombre) {
            self::$alertas["error"][] = "Ingrese su nombre";
        }

        if (!$this->usuario_email) {
            self::$alertas["error"][] = "Ingrese su email";
        }

        return self::$alertas;
    }


    public function validarCambioDePassword($passwordActual, $nuevoPassword) {

        $verify_password = password_verify($passwordActual, $this->usuario_password);


        if (!$verify_password) {
            self::$alertas["error"][] = "Su password actual no coincide";
        }


        if (strlen($this->usuario_password) < 7 || strlen($nuevoPassword) < 7){
            self::$alertas["error"][] = "Su password debe tener al menos 7 caracteres";

        }

        return self::$alertas;

    }


}


?>