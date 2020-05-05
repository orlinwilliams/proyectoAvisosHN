<?php
require_once("conexion.php");
mb_internal_encoding('UTF-8');

switch ($_GET['accion']) { //DATOS DEL DIA
    case '1':
        $conexion = new conexion();
        $sqlUsuarios = "SELECT COUNT(*) AS cantidadUsuarios  FROM usuario WHERE LEFT(fechaRegistro,10)=CURDATE()";
        $sqlAnuncios = "SELECT COUNT(*) AS cantidadAnuncios FROM anuncios WHERE LEFT(fechaPublicacion,10)=CURDATE()";
        $sqlDenuncias = "SELECT COUNT(*) AS cantidadDenuncias FROM denuncias WHERE fechaRegistro=now()";
        $sqlComentarios = "SELECT COUNT(*) AS cantidadComentarios FROM comentariosvendedor WHERE fechaRegistro=now()";
        $cantidadUsuarios;
        $cantidadAnuncios;
        $cantidadDenuncias;
        $cantidadComentarios;
        if ($resultado1 = $conexion->ejecutarInstruccion($sqlUsuarios)) {
            $fila = $resultado1->fetch_assoc();
            $cantidadUsuarios = $fila["cantidadUsuarios"];
        } else {
            echo "error en consulta USUARIOS ";
        }
        if ($resultado2 = $conexion->ejecutarInstruccion($sqlAnuncios)) {
            $fila2 = $resultado2->fetch_assoc();
            $cantidadAnuncios = $fila2["cantidadAnuncios"];
        } else {
            echo "error en consulta anuncios ";
        }
        if ($resultado3 = $conexion->ejecutarInstruccion($sqlDenuncias)) {
            $fila3 = $resultado3->fetch_assoc();
            $cantidadDenuncias = $fila3["cantidadDenuncias"];
        } else {
            echo "error en consulta denuncias ";
        }
        if ($resultado4 = $conexion->ejecutarInstruccion($sqlComentarios)) {
            $fila4 = $resultado4->fetch_assoc();
            $cantidadComentarios = $fila4["cantidadComentarios"];
        } else {
            echo "error en consulta comentarios ";
        }
        echo json_encode(array("cantidadUsuarios" => $cantidadUsuarios, "cantidadAnuncios" => $cantidadAnuncios, "cantidadDenuncias" => $cantidadDenuncias, "cantidadComentarios" => $cantidadComentarios));
        break;

    case '2': // DATOS DE INICIO
        $conexion = new Conexion();
        $datos = array();
        $sqlPublicaciones = "SELECT * FROM publicaciones_anio";
        $sqlCategoria = "SELECT * FROM publicaciones_categoria";
        $sqlLugar = "SELECT * FROM publicaciones_lugar";
        $sqlUsuarios = "SELECT * FROM usuarios_mes";
        if ($resultado1 = $conexion->ejecutarInstruccion($sqlPublicaciones)) {
            while ($row = $conexion->obtenerFila($resultado1)) {
                $datos["publicaciones"][$row["mes"]] = $row["publicaciones"];
            }
        } else {
            echo "Ha ocurrido un error al obtener las publicaciones por año";
        }
        if ($resultado2 = $conexion->ejecutarInstruccion($sqlCategoria)) {
            while ($row2 = $conexion->obtenerFila($resultado2)) {
                $datos["categorias"][$row2["nombregrupo"]] = $row2["publicaciones"];
            }
        } else {
            echo "Ha ocurrido un error al obtener las categorías por año";
        }
        if ($resultado3 = $conexion->ejecutarInstruccion($sqlLugar)) {
            while ($row3 = $conexion->obtenerFila($resultado3)) {
                $datos["lugar"][$row3["nombreDepartamento"]] = $row3["publicaciones"];
            }
        } else {
            echo "Ha ocurrido un error al obtener los lugares por año";
        }
        if ($resultado4 = $conexion->ejecutarInstruccion($sqlUsuarios)) {
            while ($row4 = $conexion->obtenerFila($resultado4)) {
                $datos["usuario"][$row4["mes"]] = $row4["publicaciones"];
            }
        } else {
            echo "Ha ocurrido un error al obtener los usuarios por año";
        }
        echo json_encode($datos);
        break;
    case '3': // DATOS A COMPARAR

        break;
}
