<?php
require_once("conexion.php");

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

        break;

    case '2': // DATOS A COMPARAR

        break;
}
