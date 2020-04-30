<?php
require_once("conexion.php");

switch ($_GET["accion"]) {
    case '1':
        $conexion = new Conexion();
        $sql = 'SELECT u.idUsuario, concat_ws(" ", u.pNombre, u.pApellido) as nombre, u.correoElectronico, u.numTelefono, tu.tipoUsuario,
                    u.fechaRegistro, (SELECT COUNT(*) FROM anuncios a WHERE a.idUsuario = u.idUsuario) as publicaciones,
                    (SELECT COUNT(*) FROM denuncias d INNER JOIN anuncios a2 ON a2.idAnuncios=d.idAnuncios WHERE a2.idUsuario=u.idUsuario ) as denuncias
                    FROM usuario u
                    INNER JOIN tipousuario tu ON tu.idTipoUsuario=u.idtipoUsuario
                    WHERE u.estado=1;';
        $respuesta = $conexion->ejecutarInstruccion($sql);
        if (!$respuesta) {
            echo json_encode(array("error" => "true", "mensaje" => "Ha ocurrido algo inesperado"));
        } else {
            $datos = array();
            while ($fila = $conexion->obtenerFila($respuesta)) {
                $datos[] = array(
                    "idUsuario" => $fila["idUsuario"], "nombre" => $fila["nombre"], "correoElectronico" => $fila["correoElectronico"],
                    "numTelefono" => $fila["numTelefono"], "tipoUsuario" => $fila["tipoUsuario"], "fechaRegistro" => $fila["fechaRegistro"],
                    "publicaciones" => $fila["publicaciones"], "denuncias" => $fila["denuncias"]
                );
            }
            echo json_encode($datos);
        }
        break;
    case '2':
        if (isset($_POST["idUsuario"])) {
            $idUsuario = $_POST["idUsuario"];
        }
        if ($idUsuario == "" | $idUsuario == NULL) {
            echo "idUsuario no ingresado";
        } else {
            $conexion = new Conexion();
            //SET @p0='4'; CALL `SP_ELIMINAR_ANUNCIO_ADMIN`(@p0, @p1, @p2); SELECT @p1 AS `pbOcurrioError`, @p2 AS `pcMensaje`;
            $conexion = new conexion();
            $sql = "CALL `SP_ELIMINAR_ANUNCIO_ADMIN`('$idUsuario', @p0, @p1);";
            $salida = "SELECT @p1 AS `pcMensaje`;";
            $resultado = $conexion->ejecutarInstruccion($sql);
            $respuesta = $conexion->ejecutarInstruccion($salida);
            if (!$respuesta) {
                echo "No hay respuesta del procedimiento";
            } else {
                $fila = $conexion->obtenerFila($respuesta);
                echo $fila["pcMensaje"];
            }
            $conexion->cerrarConexion();
        }
        break;

    default:
        echo "Selecciona una opción por favor";
        break;
}
