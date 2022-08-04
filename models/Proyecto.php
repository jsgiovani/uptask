<?php
namespace Model;

class Proyecto extends ActiveRecord {
    protected static $columnasDB = ["proyecto_id", "proyecto_nombre", "proyecto_url", "proyecto_propietarioId"];
    protected static $tabla = "proyectos";
    protected static $llavePrimaria = "proyecto_id";

    public $proyecto_id;
    public $proyecto_nombre;
    public $proyecto_url;
    public $proyecto_propietarioId;

    public function __construct($args = array()){
        $this->proyecto_id = $args['proyecto_id'] ?? null;
        $this->proyecto_nombre = $args['proyecto_nombre'] ?? "";
        $this->proyecto_url = $args['proyecto_url'] ?? "";
        $this->proyecto_propietarioId = $args['proyecto_propietarioId'] ?? 0;
    }

    public function validarNombre(){
        if(!$this->proyecto_nombre){
            self::$alertas["error"][] = "Ingrese el nombre del proyecto";
        }
        return self::$alertas;
    }

}

?>