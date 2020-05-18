<?php

require_once("conexion.php");

switch ($_GET['accion']) {
    case '1': // GESTION DE PUBLICACIONES EN TABLA
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
                        "idAnuncios" => $row["idAnuncios"], "idUsuario" => $row["idUsuario"],
                        "nombre" => $row["nombre"], "precio" => $row["precio"],
                        "nombreVendedor" => $row["nombreVendedor"], "fechaPublicacion" => $row["fechaPublicacion"],
                        "fechaLimite" => $row["fechaLimite"], "nombreCategoria" => $row["nombreCategoria"]
                    );
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
        if (isset($_POST["txt_idanuncios"])) {
            $idAnuncio = $_POST["txt_idanuncios"];
        }
        if (isset($_POST["txt_idusuario"])) {
            $idUsuario = $_POST["txt_idusuario"];
        }
        if ($idAnuncio == "" || $idAnuncio == NULL) {
            echo "ingrese el ID del anuncio";
        } else {
            $conexion = new conexion();
            $sql = "CALL `SP_ELIMINAR_ANUNCIO`('$idAnuncio', '$idUsuario', @p3);";
            $salida = "SELECT @p3 AS `pcMensaje`;";
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
    case '3': //ACTUALIZAR FECHA LIMITE
        if (isset($_POST["txt_idanuncio"])) {
            $idAnuncio = $_POST["txt_idanuncio"];
        }
        if (isset($_POST["fechaactualizada"])) {
            $fechaAct = $_POST["fechaactualizada"];
        }

        $conexion = new conexion();
        $fechaupdate = "UPDATE anuncios SET fechaLimite= '$fechaAct'
            WHERE idAnuncios=$idAnuncio;";
        $respuesta = $conexion->ejecutarInstruccion($fechaupdate);
        if (!$respuesta) {
            echo "No se ha actualizado";
        } else {
            echo "exito";
        }
        $conexion->cerrarConexion();

        break;
    case '4': // CARGAR LOS DATOS DEL INFOBOX INICIAL
        $conexion = new conexion();
        $vendidos = "SELECT COUNT(*) AS vendidos FROM `razonborrado` WHERE razon='Vendido'";
        $cambiarParecer = "SELECT COUNT(*) AS cambiarParecer FROM `razonborrado` WHERE razon='Cambié de parecer, no quiero ponerlo en venta'";
        $borrados = "SELECT COUNT(*) AS borrados FROM `razonborrado`";
        $porqueQuiero = "SELECT COUNT(*) AS porqueQuiero FROM `razonborrado` WHERE razon='Porque quiero'";
        $otraRazon = "SELECT COUNT(*) AS otraRazon FROM `razonborrado` WHERE razon='Otra razón'";
        if ($resultado1 = $conexion->ejecutarInstruccion($vendidos)) {
            $fila = $resultado1->fetch_assoc();
            $vendidos = $fila["vendidos"];
        } else {
            echo "error en consulta USUARIOS ";
        }
        if ($resultado2 = $conexion->ejecutarInstruccion($cambiarParecer)) {
            $fila2 = $resultado2->fetch_assoc();
            $cambiarParecer = $fila2["cambiarParecer"];
        } else {
            echo "error en consulta anuncios ";
        }
        if ($resultado5 = $conexion->ejecutarInstruccion($borrados)) {
            $fila5 = $resultado5->fetch_assoc();
            $borrados = $fila5["borrados"];
        } else {
            echo "error en consulta anuncios ";
        }
        if ($resultado3 = $conexion->ejecutarInstruccion($porqueQuiero)) {
            $fila3 = $resultado3->fetch_assoc();
            $porqueQuiero = $fila3["porqueQuiero"];
        } else {
            echo "error en consulta denuncias ";
        }
        if ($resultado4 = $conexion->ejecutarInstruccion($otraRazon)) {
            $fila4 = $resultado4->fetch_assoc();
            $otraRazon = $fila4["otraRazon"];
        } else {
            echo "error en consulta comentarios ";
        }
        echo json_encode(array("vendidos" => $vendidos, "cambiarParecer" => $cambiarParecer, "borrados" => $borrados, "porqueQuiero" => $porqueQuiero, "otraRazon" => $otraRazon));
        break;
    default:
        echo "ingrese una opcion valida";
        break;
}
