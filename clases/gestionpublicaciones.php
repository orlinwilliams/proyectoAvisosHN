<?php

require_once("conexion.php");

switch($_GET['accion']){
    case '1':       // GESTION DE PUBLICACIONES EN TABLA
        $conexion = new conexion();
        $sql = "SELECT idAnuncios,u.idUsuario, nombre, precio, concat(u.pNombre,' ', u.pApellido) as nombreVendedor,
                        fechaPublicacion, fechaLimite, c.nombreCategoria  
                FROM anuncios a             
                INNER JOIN usuario u ON u.idUsuario=a.idUsuario
                INNER JOIN categoria c ON c.idcategoria=a.idcategoria
                ORDER BY idAnuncios DESC"; //CONSULTA DE ANUNCIOS
        if ($resultado = $conexion->ejecutarInstruccion($sql)) {
            if ($resultado->num_rows != 0) {
                $datos = array();
                $i = 0;
                while ($row = $resultado->fetch_array()) {
                    $datos[] = array(
                        "idAnuncios" => $row["idAnuncios"],"idUsuario" => $row["idUsuario"], 
                        "nombre" => $row["nombre"],"precio" => $row["precio"],
                        "nombreVendedor" => $row["nombreVendedor"], "fechaPublicacion" => $row["fechaPublicacion"],
                        "fechaLimite" => $row["fechaLimite"],"nombreCategoria" => $row["nombreCategoria"]);
                   
                }
                
                echo json_encode($datos);
            } else {
                echo json_encode(array("error" => true, "mensaje" => "No hay anuncios"));
            }
        } else {
            echo json_encode(array("error" => true, "mensaje" => "fallo en la consulta"));
        }
        $conexion->cerrarConexion();

        break;
        case '2': //ELIMINAR ANUNCIO
            if(isset($_POST["txt_idanuncios"])){
                $idAnuncio=$_POST["txt_idanuncios"];
            }
            if(isset($_POST["txt_idusuario"])){
                $idUsuario=$_POST["txt_idusuario"];
            }
            if($idAnuncio == "" || $idAnuncio == NULL){
                echo "ingrese el ID del anuncio";
            }
            else{
            $conexion = new conexion();
            $urls="SELECT idFotos, idAnuncios, localizacion FROM fotos
            WHERE idAnuncios=$idAnuncio;";
            $respuesta=$conexion->ejecutarInstruccion($urls);
            while($fila =  $conexion->obtenerFila($respuesta)){
                $direccion=$fila["localizacion"];
                unlink($direccion);
            }
            $sql = "CALL `SP_ELIMINAR_ANUNCIO`('$idAnuncio', '$idUsuario', @p3);";
            $salida = "SELECT @p3 AS `pcMensaje`;";
                $resultado = $conexion->ejecutarInstruccion($sql);
                $respuesta = $conexion->ejecutarInstruccion($salida);
                if(!$respuesta){
                    echo "No hay respuesta del procedimiento";
                }
                else{
                    $fila=$conexion->obtenerFila($respuesta);
                    echo $fila["pcMensaje"];
                }
                $conexion->cerrarConexion();
            }                                     
        break;
        case '3': //ACTUALIZAR FECHA LIMITE
            if(isset($_POST["txt_idanuncio"])){
                $idAnuncio=$_POST["txt_idanuncio"];
            }
            if(isset($_POST["fechaactualizada"])){
                $fechaAct=$_POST["fechaactualizada"];
            }
            
            $conexion = new conexion();
            $fechaupdate="UPDATE anuncios SET fechaLimite= '$fechaAct'
            WHERE idAnuncios=$idAnuncio;";
            $respuesta=$conexion->ejecutarInstruccion($fechaupdate);
            if(!$respuesta){
                echo "No se ha actualizado";
            }else{
                echo "exito";
            }
             $conexion->cerrarConexion();
                                               
        break;
}
