<?php

namespace Controllers;

use MVC\Router;
use Model\Tarea;
use Model\Proyecto;

class TareaController
{
    public static function obtener()
    {
        $url = $_GET['proyecto_url'] ?? null;
        if ($url) {
            $proyecto = Proyecto::where("proyecto_url", $url);
            if (!empty($proyecto)) {
               $tareas = Tarea::belongsTo("tarea_proyectoId",$proyecto->proyecto_id);
               echo json_encode($tareas);
            }
        }

       
    }


    public static function crear()
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            session_start();

            $proyecto_url = $_POST["proyecto_url"];
            $proyecto = Proyecto::where("proyecto_url", $proyecto_url);

            if (!$proyecto) {
                $respuesta = array(
                    "alerta" => "Hubo un error",
                    "tipo" => "error",
                    "respuesta" => false

                );
            } else {
                if ($_SESSION["id"] == $proyecto->proyecto_propietarioId && $proyecto->proyecto_url == $proyecto_url) {
                  
                    $tarea_nombre = $_POST["tarea_nombre"];
                    $tarea_proyectoId = $proyecto->proyecto_id;

                 
                    $args = array(
                        "tarea_nombre" => $tarea_nombre,
                        "tarea_proyectoId" => $tarea_proyectoId
                    );

                    $tarea = new Tarea($args);

                    $guardarTarea = $tarea->crear();
                    if (!empty($guardarTarea)) {
                        $respuesta = array(
                            "alerta" => "Guardado exitosamente",
                            "tipo" => "exito",
                            "respuesta" => true,
                            "tarea_id"=>$guardarTarea["id"],
                            "tarea_proyectoId" => $proyecto->proyecto_id


        
                        );
                    }
       
                }else {
                    $respuesta = array(
                        "alerta" => "Hubo un error",
                        "tipo" => "error",
                        "respuesta" => false
    
                    );
                }

            }



            echo json_encode($respuesta);


        }
    }


    public static function actualizar()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {



            $proyecto_url = $_POST["proyecto_url"];
            session_start();
            $proyecto_propietarioId = $_SESSION["id"];
            $proyecto = Proyecto::where("proyecto_url", $proyecto_url);
            if (!empty($proyecto) && $proyecto->proyecto_propietarioId == $proyecto_propietarioId) {
                unset($_POST['proyecto_url']);
                $tarea = new Tarea;
                $tarea->sincronizar($_POST);
                $actualizar = $tarea->actualizar();
            }


            $respuesta = array(
                "alerta" => "recibido",
                "respuesta" => $actualizar
            );


            echo json_encode($respuesta);

           
        }
    }


    public static function eliminar(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            session_start();
            $proyecto_url = $_POST["proyecto_url"];
            $proyecto = Proyecto::where("proyecto_url", $proyecto_url);
            if (!empty($proyecto) &&  $proyecto->proyecto_propietarioId == $_SESSION["id"] )  {
                
                $tarea= new Tarea;
                unset($_POST["proyecto_url"]);
                $tarea->sincronizar($_POST);
                $eliminar = $tarea->eliminar();

            }
            $respuesta = array(
                "respuesta" => $eliminar
            );

            echo json_encode($respuesta);
        }
    }

    
}
