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
        $conexion = new Conexion();
        $anio1 = 2019;
        //Verififca que ingrese el primer año
        /*if (isset($_POST["anio1"])) {
            $anio1 = $_POST["anio1"];
        }
        if ($anio1 == "" || $anio1 == NULL) {
            $respuesta = "Ingrese el anio uno";
            echo $respuesta;
        }*/
        ////////////////////////////////////////////////////////Código para cargar el primer año
        $datos = array();
        $sqlPublicaciones = "SELECT CASE MONTH(fechaPublicacion)
                                WHEN 1 THEN 'Enero'
                                WHEN 2 THEN 'Febrero'
                                WHEN 3 THEN 'Marzo'
                                WHEN 4 THEN 'Abril'
                                WHEN 5 THEN 'Mayo'
                                WHEN 6 THEN 'Junio'
                                WHEN 7 THEN 'Julio'
                                WHEN 8 THEN 'Agosto'
                                WHEN 9 THEN 'Septiembre'
                                WHEN 10 THEN 'Octubre'
                                WHEN 11 THEN 'Noviembre'
                                WHEN 12 THEN 'Diciembre'
                                END mes, COUNT(*) as publicaciones
                                FROM anuncios
                                WHERE YEAR(fechaPublicacion)='$anio1'
                                GROUP BY mes
                                ORDER BY fechaPublicacion ASC;";
        $sqlCategoria = "SELECT nombregrupo, COUNT(*) as publicaciones
                            FROM anuncios
                            INNER JOIN categoria ON categoria.idCategoria=anuncios.idCategoria
                            INNER JOIN grupoCategoria ON grupoCategoria.idgrupocategoria=categoria.idgrupocategoria
                            WHERE YEAR(fechaPublicacion)='$anio1'
                            GROUP BY nombregrupo
                        ORDER by nombregrupo ASC;";
        $sqlLugar = "SELECT nombreDepartamento, COUNT(*) as publicaciones
                        FROM anuncios
                        INNER JOIN municipios ON municipios.idMunicipios=anuncios.idMunicipios
                        INNER JOIN departamentos ON departamentos.idDepartamentos=municipios.idDepartamentos
                        WHERE YEAR(fechaPublicacion)='$anio1'
                        GROUP BY nombreDepartamento
                        ORDER by departamentos.idDepartamentos ASC;";
        $sqlUsuarios = "SELECT CASE MONTH(fechaRegistro)
                            WHEN 1 THEN 'Enero'
                            WHEN 2 THEN 'Febrero'
                            WHEN 3 THEN 'Marzo'
                            WHEN 4 THEN 'Abril'
                            WHEN 5 THEN 'Mayo'
                            WHEN 6 THEN 'Junio'
                            WHEN 7 THEN 'Julio'
                            WHEN 8 THEN 'Agosto'
                            WHEN 9 THEN 'Septiembre'
                            WHEN 10 THEN 'Octubre'
                            WHEN 11 THEN 'Noviembre'
                            WHEN 12 THEN 'Diciembre'
                            END mes, COUNT(idUsuario) as publicaciones
                            FROM usuario
                            WHERE YEAR(fechaRegistro)='$anio1' AND estado=1
                            GROUP BY mes
                        ORDER by fechaRegistro ASC;";
        if ($resultado1 = $conexion->ejecutarInstruccion($sqlPublicaciones)) {
            while ($row = $conexion->obtenerFila($resultado1)) {
                $datos["anio1"]["publicaciones"][$row["mes"]] = $row["publicaciones"];
            }
        } else {
            echo "Ha ocurrido un error al obtener las publicaciones por año";
        }
        if ($resultado2 = $conexion->ejecutarInstruccion($sqlCategoria)) {
            while ($row2 = $conexion->obtenerFila($resultado2)) {
                $datos["anio1"]["categorias"][$row2["nombregrupo"]] = $row2["publicaciones"];
            }
        } else {
            echo "Ha ocurrido un error al obtener las categorías por año";
        }
        if ($resultado3 = $conexion->ejecutarInstruccion($sqlLugar)) {
            while ($row3 = $conexion->obtenerFila($resultado3)) {
                $datos["anio1"]["lugar"][$row3["nombreDepartamento"]] = $row3["publicaciones"];
            }
        } else {
            echo "Ha ocurrido un error al obtener los lugares por año";
        }
        if ($resultado4 = $conexion->ejecutarInstruccion($sqlUsuarios)) {
            while ($row4 = $conexion->obtenerFila($resultado4)) {
                $datos["anio1"]["usuario"][$row4["mes"]] = $row4["publicaciones"];
            }
        } else {
            echo "Ha ocurrido un error al obtener los usuarios por año";
        }
        ////////////////////////////////////////////////////////Verifica si hay un segundo año
        $anio2 = 2020;
        /*if (isset($_POST["anio2"])) {
            $anio2 = $_POST["anio2"];
        }
        if ($anio1 == "" || $anio1 == NULL) {
            $respuesta = "Ingrese el anio uno";
            echo $respuesta;
        } else if ($anio2 == "" || $anio2 == NULL) {
            $respuesta = "Ingrese el anio 2";
            echo $respuesta;
        }*/
        $sqlPublicaciones = "SELECT CASE MONTH(fechaPublicacion)
                                WHEN 1 THEN 'Enero'
                                WHEN 2 THEN 'Febrero'
                                WHEN 3 THEN 'Marzo'
                                WHEN 4 THEN 'Abril'
                                WHEN 5 THEN 'Mayo'
                                WHEN 6 THEN 'Junio'
                                WHEN 7 THEN 'Julio'
                                WHEN 8 THEN 'Agosto'
                                WHEN 9 THEN 'Septiembre'
                                WHEN 10 THEN 'Octubre'
                                WHEN 11 THEN 'Noviembre'
                                WHEN 12 THEN 'Diciembre'
                                END mes, COUNT(*) as publicaciones
                                FROM anuncios
                                WHERE YEAR(fechaPublicacion)='$anio2'
                                GROUP BY mes
                                ORDER BY fechaPublicacion ASC;";
        $sqlCategoria = "SELECT nombregrupo, COUNT(*) as publicaciones
                            FROM anuncios
                            INNER JOIN categoria ON categoria.idCategoria=anuncios.idCategoria
                            INNER JOIN grupoCategoria ON grupoCategoria.idgrupocategoria=categoria.idgrupocategoria
                            WHERE YEAR(fechaPublicacion)='$anio2'
                            GROUP BY nombregrupo
                            ORDER by nombregrupo ASC;";
        $sqlLugar = "SELECT nombreDepartamento, COUNT(*) as publicaciones
                        FROM anuncios
                        INNER JOIN municipios ON municipios.idMunicipios=anuncios.idMunicipios
                        INNER JOIN departamentos ON departamentos.idDepartamentos=municipios.idDepartamentos
                        WHERE YEAR(fechaPublicacion)='$anio2'
                        GROUP BY nombreDepartamento
                        ORDER by departamentos.idDepartamentos ASC;";
        $sqlUsuarios = "SELECT CASE MONTH(fechaRegistro)
                            WHEN 1 THEN 'Enero'
                            WHEN 2 THEN 'Febrero'
                            WHEN 3 THEN 'Marzo'
                            WHEN 4 THEN 'Abril'
                            WHEN 5 THEN 'Mayo'
                            WHEN 6 THEN 'Junio'
                            WHEN 7 THEN 'Julio'
                            WHEN 8 THEN 'Agosto'
                            WHEN 9 THEN 'Septiembre'
                            WHEN 10 THEN 'Octubre'
                            WHEN 11 THEN 'Noviembre'
                            WHEN 12 THEN 'Diciembre'
                            END mes, COUNT(idUsuario) as publicaciones
                            FROM usuario
                            WHERE YEAR(fechaRegistro)='$anio2' AND estado=1
                            GROUP BY mes
                            ORDER by fechaRegistro ASC;";
        if ($resultado1 = $conexion->ejecutarInstruccion($sqlPublicaciones)) {
            while ($row = $conexion->obtenerFila($resultado1)) {
                $datos["anio2"]["publicaciones"][$row["mes"]] = $row["publicaciones"];
            }
        } else {
            echo "Ha ocurrido un error al obtener las publicaciones por año";
        }
        if ($resultado2 = $conexion->ejecutarInstruccion($sqlCategoria)) {
            while ($row2 = $conexion->obtenerFila($resultado2)) {
                $datos["anio2"]["categorias"][$row2["nombregrupo"]] = $row2["publicaciones"];
            }
        } else {
            echo "Ha ocurrido un error al obtener las categorías por año";
        }
        if ($resultado3 = $conexion->ejecutarInstruccion($sqlLugar)) {
            while ($row3 = $conexion->obtenerFila($resultado3)) {
                $datos["anio2"]["lugar"][$row3["nombreDepartamento"]] = $row3["publicaciones"];
            }
        } else {
            echo "Ha ocurrido un error al obtener los lugares por año";
        }
        if ($resultado4 = $conexion->ejecutarInstruccion($sqlUsuarios)) {
            while ($row4 = $conexion->obtenerFila($resultado4)) {
                $datos["anio2"]["usuario"][$row4["mes"]] = $row4["publicaciones"];
            }
        } else {
            echo "Ha ocurrido un error al obtener los usuarios por año";
        }
        echo json_encode($datos);
        break;

    default:
        echo "Ingresa una acción";
        break;
}
