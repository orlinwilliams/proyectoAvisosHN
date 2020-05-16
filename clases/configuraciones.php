<?php
require_once("conexion.php");
switch ($_GET["accion"]) {
    case '1': ///////////AGREGAR GRUPO DE CATEGORIA
        if (isset($_POST["grupo"])) {
            $grupoCat = $_POST["grupo"];
        }
        if ($grupoCat == "" | $grupoCat == NULL) {
            echo "Debe agregar el grupo de categoria";
        } else {
            $conexion = new conexion();
            $sqlid="SELECT MAX(idgrupocategoria+1) as idgrupo FROM `grupocategoria` ;";
            $respuesta=$conexion->ejecutarInstruccion($sqlid);
            
            if($resultadoId=$conexion->obtenerFila($respuesta)){
                
                $lastId=$resultadoId["idgrupo"];
                $conexion = new conexion();
                $sql1 = "INSERT INTO grupocategoria (idgrupocategoria, nombregrupo) VALUES ('$lastId' ,'$grupoCat');";
                
                if ($respuesta = $conexion->ejecutarInstruccion($sql1)) {
                    echo  "Grupo de categoria agregado con éxito";
                } else {
                    echo  "No hay respuesta del servidor";
                }
                
                
            }
            $conexion->cerrarConexion();
        }
        

        break;
    case '2': ///////////AGREGAR CATEGORIA
        if (isset($_POST["grupo"])) {
            $grupoCat = $_POST["grupo"];
        }
        if (isset($_POST["categoria"])) {
            $cat= $_POST["categoria"];
        }
        if ($grupoCat == "" | $grupoCat == NULL) {
            echo "Debe agregar el grupo de categoria";
        }
        if ($cat == "" | $cat == NULL) {
            echo "Debe agregar la categoria";
        } else {
            $conexion = new conexion();
            $sqlidmax="SELECT (max(idcategoria)+1) as maxcat FROM `categoria`;";
            $respuesta1=$conexion->ejecutarInstruccion($sqlidmax);
                if ($resultadoIdmax=$conexion->obtenerFila($respuesta1)) {
                    $Idcat=$resultadoIdmax["maxcat"];
                    $sql1 = "INSERT INTO `categoria`(`idcategoria`, `nombreCategoria`, `idgrupocategoria`) 
                            VALUES ('$Idcat','$cat','$grupoCat');";
                    
                    if ($respuesta = $conexion->ejecutarInstruccion($sql1)) {
                        echo  "Categoria agregada con éxito";
                    } else {
                        echo  "No hay respuesta del servidor";
                    } 
                }   
            
            $conexion->cerrarConexion();
        }
        

        break;
    case '3': ///////////CANTIDAD DE DIAS PARA LAS PUBLICACIONES
        //$_POST["dias"] = 14;
        if (isset($_POST["dias"])) {
            $dias = $_POST["dias"];
        }
        if ($dias == "" | $dias == NULL) {
            echo json_encode(array("error" => TRUE, "mensaje" => "Cantidad de días no ingresados"));
        } else {
            $conexion = new Conexion();
            ////////SCRIPT PARA LA MODIFICACION DEL SP
            $sql = "DROP PROCEDURE IF EXISTS SP_DURACION_PUBLICACIONES;
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
                    
                    END;";
            if ($respuesta = $conexion->ejecutarMultipleInstruccion($sql)) {
                ///////// MENSAJE AL INTENTAR GUARDAR EL SP
                echo json_encode(array("error" => FALSE, "mensaje" => "El cambio se ha efectuado correctamente"));
            } else {
                //////// MENSAJE AL HABER UN ERROR
                echo json_encode(array("error" => TRUE, "mensaje" => "Falló la multiconsulta: (".$conexion->errno().") ".$conexion->error()));
            }
            $conexion->cerrarConexion();
        }
        
        break;
        case '4':                                                                                                   //Obtiene las categorias
            $conexion = new conexion();
            $sql = "SELECT idgrupocategoria, nombregrupo FROM `grupocategoria`
                ORDER by idgrupocategoria ASC;";
            $resultado = $conexion->ejecutarInstruccion($sql);
            if (!$resultado) {
                echo "No hay grupos de categorias";
            } else {
                while ($fila = $conexion->obtenerFila($resultado)) {                                                    //Recorre todas las filas de grupo de categoria
                  
                    echo '<option value="' .$fila["idgrupocategoria"]. '">' . $fila["nombregrupo"]. '</option>';
                }
            }
            $conexion->cerrarConexion();
            break;
        case '5':                                                                                                   //Obtiene las categorias
                $conexion = new conexion();
                $sql = "SELECT idcategoria, nombreCategoria FROM `categoria`
                    ORDER by idcategoria ASC;";
                $resultado = $conexion->ejecutarInstruccion($sql);
                if (!$resultado) {
                    echo "No hay categorias";
                } else {
                    while ($fila = $conexion->obtenerFila($resultado)) {                                                    //Recorre todas las filas de grupo de categoria
                      
                        echo '<option value="' .$fila["idcategoria"]. '">' . $fila["nombreCategoria"]. '</option>';
                    }
                }
                $conexion->cerrarConexion();
            break;
    default:
        echo "Ingrese una opción válida";
        break;
}
