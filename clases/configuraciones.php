<?php
require_once("conexion.php");
switch ($_GET["accion"]) {
    case '1': ///////////AGREGAR GRUPO DE CATEGORIA
        break;
    case '2': ///////////AGREGAR CATEGORIA
        break;
    case '3': ///////////CANTIDAD DE DIAS PARA LAS PUBLICACIONES
        if (isset($_POST["dias"])) {
            $dias = $_POST["dias"];
        }
        if ($dias == "" | $dias == NULL) {
            echo json_encode(array("error" => TRUE, "mensaje" => "cantidad de días no ingresados"));
        } else {
            $conexion = new Conexion();
            ////////AQUI DEBE IR EL SCRIPT PARA LA CREACION DEL SP
            $sql = "";
            if ($respuesta = $conexion->ejecutarInstruccion($sql)) {
                ///////// MENSAJE AL INTENTAR GUARDAR EL SP
                //echo json_encode(array("error" => FALSE, "mensaje" => "Mensaje de salida de la base de datos"));
            } else {
                echo json_encode(array("error" => true, "mensaje" => "Ha ocurrido un error"));
            }
        }
        break;
    default:
        echo "Ingrese una opción válida";
        break;
}
