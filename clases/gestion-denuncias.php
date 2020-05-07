<?php

require_once("conexion.php");

switch($_GET['accion']){
    case '1':       // GESTION DE DENUNCIAS EN TABLA
        $conexion = new conexion();
        $sql = "SELECT a.idAnuncios, u.idUsuario, idDenuncias,r.descripcion,d.comentarios, u.pNombre, a.nombre
                FROM denuncias d   
                INNER JOIN anuncios a on a.idAnuncios=d.idAnuncios
                INNER JOIN usuario u ON u.idUsuario=a.idUsuario
                INNER JOIN razondenuncia r ON r.idrazonDenuncia=d.idrazonDenuncia
                ORDER BY idDenuncias DESC;"; //CONSULTA DE DENUNCIAS
        if ($resultado = $conexion->ejecutarInstruccion($sql)) {
            if ($resultado->num_rows != 0) {
                $datos = array();
                $i = 0;
                while ($row = $resultado->fetch_array()) {
                    $datos[] = array(
                        "idAnuncios" => $row["idAnuncios"],"idUsuario" => $row["idUsuario"],"idDenuncias" => $row["idDenuncias"],
                        "descripcion" => $row["descripcion"],  "comentarios" => $row["comentarios"],
                        "pNombre" => $row["pNombre"],"nombre" => $row["nombre"]);     
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
}
?>
