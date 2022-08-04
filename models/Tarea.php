<?php
namespace Model;

class Tarea  extends ActiveRecord {
    protected static $tabla  = 'tareas';
    protected static $columnasDB  = ['tarea_id', 'tarea_nombre', 'tarea_estado', 'tarea_proyectoId'];
    protected static $llavePrimaria = 'tarea_id';

    public $tarea_id;
    public $tarea_nombre;
    public $tarea_estado;
    public $tarea_proyectoId;

    public function __construct($args = array()){
        $this->tarea_id = $args['tarea_id'] ?? null;
        $this->tarea_nombre = $args['tarea_nombre'] ?? '';
        $this->tarea_estado = $args['tarea_estado'] ?? 0;
        $this->tarea_proyectoId = $args['tarea_proyectoId'] ?? '';
    }

}

?>