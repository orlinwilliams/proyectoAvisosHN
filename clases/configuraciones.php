<?php
require_once("conexion.php");
switch ($_GET["accion"]) {
    case '1': ///////////AGREGAR GRUPO DE CATEGORIA
        #CODE...
        break;
    case '2': ///////////AGREGAR CATEGORIA
        #CODE...
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
            $sql = "DELIMITER $$
                    DROP PROCEDURE IF EXISTS SP_DURACION_PUBLICACIONES$$
                    CREATE PROCEDURE SP_DURACION_PUBLICACIONES(
                        OUT     pcMensaje      VARCHAR(1000)
                    )
                    SP:BEGIN
                        
                        DELETE FROM calificacionanuncio
                        WHERE idAnuncios IN (SELECT idAnuncios FROM anuncios WHERE DATEDIFF(CURDATE(), fechaPublicacion)>$dias);
                    
                        DELETE FROM denuncias
                        WHERE idAnuncios IN (SELECT idAnuncios FROM anuncios WHERE DATEDIFF(CURDATE(), fechaPublicacion)>$dias);
                    
                        DELETE FROM fotos
                        WHERE idAnuncios IN (SELECT idAnuncios FROM anuncios WHERE DATEDIFF(CURDATE(), fechaPublicacion)>$dias);
                    
                        DELETE FROM anuncios
                        WHERE DATEDIFF(CURDATE(), fechaPublicacion)>$dias;
                        
                        SET pcMensaje = 'las publicaciones han expirado';
                    
                        LEAVE SP;
                    
                    END$$";
            if ($respuesta = $conexion->ejecutarInstruccion($sql)) {
                ///////// MENSAJE AL INTENTAR GUARDAR EL SP
                echo json_encode(array("error" => FALSE, "mensaje" => "El cambio se ha efectuado correctamente"));
            } else {
                echo json_encode(array("error" => TRUE, "mensaje" => "Ha ocurrido un error"));
            }
        }
        break;
    default:
        echo "Ingrese una opción válida";
        break;
}
