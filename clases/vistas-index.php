<?php
require_once("conexion.php");
require_once("correo.php");

switch ($_GET["accion"]) {
    case '1':                                                                                                   //Obtiene las categorias
        $conexion = new conexion();
        $sql = "SELECT idgrupocategoria, nombregrupo FROM `grupocategoria`
            ORDER by idgrupocategoria ASC;";
        $resultado = $conexion->ejecutarInstruccion($sql);
        if (!$resultado) {
            echo "No hay categorias";
        } else {
            while ($fila = $conexion->obtenerFila($resultado)) {                                                    //Recorre todas las filas de grupo de categoria
                $idgrupocategoria = $fila["idgrupocategoria"];
                echo '<optgroup label="' . $fila["nombregrupo"] . '">';

                $sql2 = "SELECT idcategoria, nombrecategoria FROM `categoria`
                    WHERE idgrupocategoria=$idgrupocategoria
                    ORDER by idcategoria ASC;";                                                                    //Por cada grupo consultará los categorias que pertenecen al grupo

                $resultado2 = $conexion->ejecutarInstruccion($sql2);
                if ($resultado2) {
                    while ($fila2 = $conexion->obtenerFila($resultado2)) {                                          //Recorre todas las filas de categorias según el grupo
                        echo '<option value="' . $fila2["idcategoria"] . '">' . $fila2["nombrecategoria"] . '</option>';
                    }
                }
                echo '</optgroup>';
            }
        }
        $conexion->cerrarConexion();
        break;
    case '2':
        $conexion = new conexion();
        $sql = "SELECT iddepartamentos, nombredepartamento FROM `departamentos`
                ORDER by iddepartamentos ASC;";
        $resultado = $conexion->ejecutarInstruccion($sql);
        if (!$resultado) {
            echo "No hay municipios";
        } else {
            while ($fila = $conexion->obtenerFila($resultado)) {                                                    //Recorre todas las filas de departamentos
                $iddepartamento = $fila["iddepartamentos"];
                echo '<optgroup label="' . $fila["nombredepartamento"] . '">';

                $sql2 = "SELECT idmunicipios, municipio FROM `municipios`
                        WHERE iddepartamentos=$iddepartamento
                        ORDER by idmunicipios ASC;";                                                                    //Por cada departamento consultará los municipios que pertenecen al departamento

                $resultado2 = $conexion->ejecutarInstruccion($sql2);
                if ($resultado2) {
                    while ($fila2 = $conexion->obtenerFila($resultado2)) {                                          //Recorre todas las filas de municipio según el departamento
                        echo '<option value="' . $fila2["idmunicipios"] . '">' . $fila2["municipio"] . '</option>';
                    }
                }
                echo '</optgroup>';
            }
        }
        $conexion->cerrarConexion();
        break;
    case '3': //PUBLICACIONES INICIOUSUARIO
        $conexion = new conexion();
        $sql = "SELECT idAnuncios,nombre,precio,descripcion 
                    FROM anuncios ORDER BY idAnuncios DESC"; //CONSULTA PUBLICACIONES INICIO
        if ($resultado = $conexion->ejecutarInstruccion($sql)) {
            if ($resultado->num_rows != 0) {
                $datos = array();

                //$idAnuncio=$datos["idAnuncios"];
                $i = 0;
                while ($row = $resultado->fetch_array()) {

                    $datos[] = array(
                        "idAnuncios" => $row["idAnuncios"], "nombre" => $row["nombre"],
                        "precio" => $row["precio"], "descripcion" => $row["descripcion"], "fotos" => ""
                    );

                    $idAnuncio = $row["idAnuncios"];

                    $sql1 = "SELECT localizacion FROM fotos WHERE idAnuncios='$idAnuncio'";
                    if ($resultado1 = $conexion->ejecutarInstruccion($sql1)) {
                        if ($resultado1->num_rows != 0) {

                            $fotos = array();
                            while ($row1 = $resultado1->fetch_array()) {
                                $fotos[] = $row1["localizacion"];
                            }
                            $datos[$i]["fotos"] = $fotos;
                            $i++;
                        } else {
                            echo "NO HAY FOTO ";
                            break;
                        }
                    } else {
                        echo "Fallo en la consulta de fotos";
                        break;
                    }
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
    case '4':
        if (isset($_GET["idAnuncio"])) {
            $idAnuncio = $_GET["idAnuncio"];
        }
        if ($idAnuncio == "" | $idAnuncio == NULL) {
            echo "idAnuncio no ingresado";
        } else {
            $conexion = new conexion();
            $sql = "SELECT  a.idAnuncios,ROUND((SELECT AVG(valoracion) FROM calificacionanuncio WHERE idAnuncios=$idAnuncio),1) AS valoración,nombre, precio, descripcion, estadoArticulo, c.nombreCategoria,
                     g.nombregrupo, u.idUsuario, concat_ws(' ',u.pnombre, u.papellido) as nombreUsuario,
                     m.municipio,u.correoElectronico, u.numTelefono, u.fechaRegistro, u.urlFoto FROM anuncios a
                     INNER JOIN categoria c ON c.idcategoria=a.idcategoria
                     INNER JOIN grupoCategoria g ON g.idgrupocategoria=c.idgrupocategoria
                     INNER JOIN usuario u ON u.idUsuario=a.idUsuario
                     INNER JOIN municipios m ON m.idmunicipios=a.idmunicipios
                     INNER JOIN calificacionanuncio can ON can.idAnuncios=a.idAnuncios
                     LEFT JOIN calificacionesvendedor cv ON cv.idUsuario=a.idUsuario
                 WHERE a.idAnuncios = $idAnuncio;";

            $respuesta = $conexion->ejecutarInstruccion($sql);
            if (!$respuesta) {
                echo "Oops, ha ocurrido un error";
            } else {
                $datos = $conexion->obtenerFila($respuesta);
                session_start();
                $_SESSION["usuario"]["idAnuncio"] = $datos["idAnuncios"];

                $fila["info"] = array(
                    "idAnuncios" => $datos["idAnuncios"], "nombre" => $datos["nombre"], "precio" => $datos["precio"],
                    "descripcion" => $datos["descripcion"], "estadoArticulo" => $datos["estadoArticulo"], "nombreCategoria" => $datos["nombreCategoria"],
                    "nombregrupo" => $datos["nombregrupo"], "idUsuario" => $datos["idUsuario"], "correoElectronico" => $datos["correoElectronico"], "nombreUsuario" => $datos["nombreUsuario"],
                    "municipio" => $datos["municipio"], "valoración" => $datos["valoración"], "numTelefono" => $datos["numTelefono"],
                    "fechaRegistro" => $datos["fechaRegistro"], "urlFoto" => $datos["urlFoto"], "fotos" => "", "sigueVendedor" => false

                );



                $idUsuarioSeguidor = $_SESSION["usuario"]["idUsuario"];
                $idUsuarioSeguido = $datos["idUsuario"];
                $sql3 = "SELECT * FROM favoritos WHERE idSeguidor='$idUsuarioSeguidor' AND idSeguido='$idUsuarioSeguido'";
                if ($respuesta3 = $conexion->ejecutarInstruccion($sql3)) {
                    if ($respuesta3->num_rows != 0) {
                        $fila["info"]["sigueVendedor"] = true;
                    } else if ($respuesta3->num_rows == 0) {
                        $fila["info"]["sigueVendedor"] = false;
                    }
                } else {
                    echo "ERROR CONSULTA DE SEGUIR USAURIO";
                }

                $sql = "SELECT localizacion FROM fotos
                            WHERE idAnuncios=$idAnuncio;";
                $respuesta = $conexion->ejecutarInstruccion($sql);
                if (!$respuesta) {
                    echo "No se encontraron fotos";
                } else {
                    while ($row = $conexion->obtenerFila($respuesta)) {
                        $fotos[] = $row["localizacion"];
                    }
                    $fila["info"]["fotos"] = $fotos;
                }

                echo json_encode($fila);
            }

            $conexion->cerrarConexion();
        }
        break;
    case '5': //INFROMACION DEL VENDEDOR
        if (isset($_GET["idUsuario"])) {
            $idUsuario = $_GET["idUsuario"];
        }
        if ($idUsuario == "" | $idUsuario == NULL) {
            echo "idUsuario no ingresado";
        } else {
            $conexion = new conexion(); //INFORMACION DEL VENDEDOR
            $sql = "SELECT cv.cantidadEstrellas, U.idUsuario, U.pNombre,U.pApellido,U.urlFoto, U.correoElectronico,U.fechaRegistro, T.tipoUsuario,(SELECT COUNT(idUsuario) FROM anuncios WHERE idUsuario='$idUsuario') as cantidadAnuncio FROM usuario as U
                INNER JOIN tipoUsuario as T
                ON T.idTipoUsuario=U.idTipoUsuario
                INNER JOIN calificacionesvendedor as cv
                ON cv.idUsuario=U.idUsuario
                WHERE U.idUsuario='$idUsuario';";

            $respuesta = $conexion->ejecutarInstruccion($sql);
            if (!$respuesta) {
                echo "Error en consulta vendedor";
            } else {
                $datos = $conexion->obtenerFila($respuesta);

                $datosVendedor = array(
                    "idUsuario" => $datos["idUsuario"], "pNombre" => $datos["pNombre"], "pApellido" => $datos["pApellido"], "urlFoto" => $datos["urlFoto"],
                    "correoElectronico" => $datos["correoElectronico"], "fechaRegistro" => $datos["fechaRegistro"], "tipoUsuario" => $datos["tipoUsuario"],
                    "cantidadAnuncio" => $datos["cantidadAnuncio"], "cantidadEstrellas" => $datos["cantidadEstrellas"]
                );

                $sql1 = "SELECT nombre,fechaPublicacion,precio FROM anuncios WHERE idUsuario='$idUsuario'"; //INFORMACION DE LAS PUBLICACIONES
                if ($respuesta1 = $conexion->ejecutarInstruccion($sql1)) {
                    $anunciosVendedor = array();
                    if ($respuesta1->num_rows != 0) {
                        while ($row1 = $conexion->obtenerFila($respuesta1)) {
                            $anunciosVendedor[] = array("nombreAnuncio" => $row1["nombre"], "fechaAnuncio" => $row1["fechaPublicacion"], "precioAnuncio" => $row1["precio"]);
                        }
                        $sql3 = "SELECT concat_ws(' ',U.pNombre,U.pApellido) as nombreComprador,C.comentario  FROM comentariosvendedor C
                        INNER JOIN usuario U
                        ON C.idUsuarioCalificado=U.idUsuario
                        WHERE idUsuarioCalificado='$idUsuario' ORDER BY idComentariosVendedor DESC"; //INFORMACION DE COMENTARIOS

                        if ($respuesta2 = $conexion->ejecutarInstruccion($sql3)) {
                            $comentariosVendedor = array();
                            if ($respuesta2->num_rows != 0) {
                                while ($row2 = $conexion->obtenerFila($respuesta2)) {
                                    $comentariosVendedor[] = array("comentario" => $row2["comentario"], "nombreComprador" => $row2["nombreComprador"]);
                                }
                                echo json_encode(array("datosVendedor" => $datosVendedor, "anunciosVendedor" => $anunciosVendedor, "comentariosVendedor" => $comentariosVendedor));
                            } else {
                                echo json_encode(array("datosVendedor" => $datosVendedor, "anunciosVendedor" => $anunciosVendedor, "comentariosVendedor" => array("error" => true, "mensaje" => "No hay comentarios todavia")));
                            }
                        } else {
                            echo "error en consulta de comentarios";
                        }
                    } else {
                        echo json_encode(array("datosVendedor" => $datosVendedor, "anunciosVendedor" => array("error" => true, "mensaje" => "Vendedor no ha publicado todavia")));
                    }

                    //echo json_encode(array("datosVendedor"=>$datosVendedor,"anunciosVendedor"=>$anunciosVendedor));

                } else {
                    echo "error en consulta de anuncios de usuario";
                }
            }
        }
        $conexion->cerrarConexion();
        break;
    case '6': //Datos para hacer contacto con vendedor
        $conexion = new Conexion();
        session_start();
        $idUsuario = $_SESSION["usuario"]["idUsuario"];
        $pNombre = $_SESSION["usuario"]["pNombre"];
        $pApellido = $_SESSION["usuario"]["pApellido"];
        if (isset($_POST["idAnuncio2"])) {
            $idAnuncio = $_POST["idAnuncio2"];
        }
        $sql = "SELECT nombre FROM anuncios a
             WHERE a.idAnuncios= '$idAnuncio'";
        $salida = "SELECT @p10 AS `mensaje`;";                                                                //Llamado al parametro de salida del procedimiento almacenado
        $resultado = $conexion->ejecutarInstruccion($sql);
        $respuesta = $conexion->ejecutarInstruccion($salida);
        $fila5 = $conexion->obtenerFila($resultado);
        $nombreAnun = $fila5["nombre"];
        echo $nombreAnun;
        $conexion->cerrarConexion();
        break;
    case '7': ///se envia correo para hacer contacto con vendedor
        $conexion = new Conexion();
        session_start();
        $idUsuario = $_SESSION["usuario"]["idUsuario"];
        $pNombre = $_SESSION["usuario"]["pNombre"];
        $pApellido = $_SESSION["usuario"]["pApellido"];
        $correoCliente = $_SESSION["usuario"]["correoElectronico"];
        if (isset($_POST["idanuncio3"])) {
            $idAnuncio = $_POST["idanuncio3"];
        }
        if (isset($_POST["mensaje1"])) {
            $mensaje1 = $_POST["mensaje1"];
        }
        if ($mensaje1 == "" || $mensaje1 == NULL) {
            $respuesta = "Ingrese su mensaje a enviar.";
            echo $respuesta;
        }

        $sql = "SELECT nombre , u.correoElectronico, concat_ws(' ',u.pnombre, u.papellido) as nombreVendedor, u.idUsuario FROM anuncios a 
              INNER JOIN usuario u on u.idUsuario=a.idUsuario WHERE a.idAnuncios= '$idAnuncio'";
        $salida = "SELECT @p10 AS `mensaje`;";                                                                //Llamado al parametro de salida del procedimiento almacenado
        $resultado = $conexion->ejecutarInstruccion($sql);
        $respuesta = $conexion->ejecutarInstruccion($salida);
        $fila5 = $conexion->obtenerFila($resultado);
        $fila4 = $conexion->obtenerFila($respuesta);
        $correoVendedor = $fila5["correoElectronico"];
        $nombreVendedor = $fila5["nombreVendedor"];
        $idVendedor = $fila5["idUsuario"];
        if ($idVendedor == $idUsuario) {
            echo json_encode(array("error" => true, "mensaje" => "No puedes contactarte a ti mismo"));
        } else {
            $nombreServer = $_SERVER['SERVER_NAME'];
            $mensajeEncabezado = "<br>Somos MARKETHN<br><br>";
            $mensaje = $mensajeEncabezado . "El usuario: " . $pNombre . " " . $pApellido . " con correo: " . $correoCliente . " dice:<br>" . $mensaje1 . " <br> ";
            $correo = new Correo($correoVendedor, $nombreVendedor, "Cliente interesado", $mensaje);
            if ($correo->enviarCorreo()) { //SE ENVIA CORREO
                echo  json_encode(array("error" => false, "mensaje" => $fila4["mensaje"] . "Correo enviado"));
            } else {
                echo "FALLO EN ENVIO DE CORREO";
            }
        }

        $conexion->cerrarConexion();
        break;
    case '8': //INGRESA COMENTARIO

        if (!isset($_POST["idUsuario"])) {
            echo "falta idUsuario del vendedor";
        } else {
            $idUsuario = $_POST["idUsuario"]; //idVendedor
        }

        if (!isset($_POST["comentario"])) {
            echo "falta Comentario del vendedor";
        } else {
            $comentario = $_POST["comentario"];
        }

        if ($comentario == "" && $comentario == null) {
            echo "comentario vacio";
        }

        $conexion = new Conexion();
        session_start();
        $pNombre = $_SESSION["usuario"]["pNombre"];
        $pApellido = $_SESSION["usuario"]["pApellido"];
        $nombreComprador = $pNombre . " " . $pApellido;
        $idComprador = $_SESSION["usuario"]["idUsuario"];

        if ($idComprador == $idUsuario) {
            echo json_encode(array("error" => true, "mensaje" => "No puedes camentarte a ti mismo"));
        } else {
            $sql = "INSERT INTO comentariosvendedor(comentario, idUsuarioCalificador, idUsuarioCalificado) VALUES('$comentario','$idComprador','$idUsuario')";
            if ($resultado = $conexion->ejecutarInstruccion($sql)) {
                echo json_encode(array("error" => false, "mensaje" => "Comentario agregado con exito", "nombreComprador" => $nombreComprador));
            } else {
                echo json_encode(array("error" => true, "mensaje" => "Erro en consulta de insert Comentario"));;
            }
        }

        $conexion->cerrarConexion();
        break;
    case '9': //se inserta la calificacion del anuncio
        session_start();
        $idAnuncio = $_SESSION["usuario"]["idAnuncio"];
        echo $idAnuncio;
        if (isset($_POST["valoracion"])) {
            $estrellas = $_POST["valoracion"];
        }
        if ($estrellas == "" | $estrellas == NULL) {
            echo "debe valorar el anuncio";
        } else {
            $conexion = new conexion();
            $sql = "INSERT INTO calificacionanuncio (idAnuncios, valoracion) VALUES ($idAnuncio, $estrellas);";
            $respuesta = $conexion->ejecutarInstruccion($sql);
            if (!$respuesta) {
                echo  "No hay respuesta del servidor";
            } else {
                $sql = "CALL `SP_CALIFICACION_VENDEDOR`('$idAnuncio', @p1);";
                $salida = "SELECT @p1 AS `MensajeError`";                                                                //Llamado al parametro de salida del procedimiento almacenado
                $resultado = $conexion->ejecutarInstruccion($sql);
                $respuesta = $conexion->ejecutarInstruccion($salida);
                if (!$respuesta) {
                    echo "No hay respuesta del procedimiento";
                } else {
                    echo "valorado correctamente";
                }
            }
        }
        $conexion->cerrarConexion();
        break;


    case '10':
        session_start();
        $idAnuncio = $_SESSION["usuario"]["idAnuncio"];
        $respuesta = "";
        if (isset($_POST["razónDenuncia"])) {
            $denuncia = $_POST["razónDenuncia"];
        }
        if ($denuncia == "" | $denuncia == NULL) {
            $respuesta .= "razón de denuncia, ";
        }
        if (isset($_POST["comentario-denuncia"])) {
            $comentario = $_POST["comentario-denuncia"];
        }
        if ($comentario == "" | $comentario == NULL) {
            $respuesta .= "comentario, ";
        }
        if ($respuesta <> "" || $respuesta <> NULL) {
            $respuesta2 = "Verifique los siguientes campos: " . $respuesta;
            echo json_encode(array("error" => TRUE, "mensaje" => "$respuesta2"));
        } else {
            $conexion = new conexion();
            $sql = "INSERT INTO denuncias (idrazonDenuncia,idAnuncios,comentarios) VALUES ($denuncia, $idAnuncio, '$comentario');";
            $respuesta = $conexion->ejecutarInstruccion($sql);
            if (!$respuesta) {
                echo json_encode(array("error" => TRUE, "mensaje" => "Error al enviar la denuncia"));
            } else {
                echo json_encode(array("error" => FALSE, "mensaje" => "Tu denuncia ha sido enviada, pronto será revisada"));
            }
            $conexion->cerrarConexion();
        }

        break;

    case '11': // FAVORTOS
        if (isset($_POST["idSeguido"])) {
            $idSeguido = $_POST["idSeguido"];
            $conexion = new conexion();

            session_start();
            $idSeguidor = $_SESSION["usuario"]["idUsuario"];
            if ($idSeguidor == $idSeguido) {
                echo json_encode(array("error" => true, "mensaje" => "No puedes seguirte a ti mismo"));
            } else {
                $sql = "INSERT INTO favoritos(idSeguidor,idSeguido) VALUES('$idSeguidor','$idSeguido') ";
                if ($respuesta = $conexion->ejecutarInstruccion($sql)) {
                    echo json_encode(array("error" => false, "idSeguido" => $idSeguido, "mensaje" => "Se ha añadido a sus favoritos, recibiras notificaciones de este vendedor"));
                } else {
                    echo json_encode(array("error" => true, "mensaje" => "fallo consulta de insert"));
                }
            }
            $conexion->cerrarConexion();
        } else {
            echo json_encode(array("error" => true, "mensaje" => "No hay idUsuario"));
        }


        break;
    case '12': // FAVORTOS
        if (isset($_POST["idSeguido"])) {
            $idSeguido = $_POST["idSeguido"];
            $conexion = new conexion();

            session_start();
            $idSeguidor = $_SESSION["usuario"]["idUsuario"];
            if ($idSeguidor == $idSeguido) {
                echo json_encode(array("error" => true, "mensaje" => "No puedes seguirte a ti mismo"));
            } else {
                $sql = "DELETE FROM favoritos WHERE idSeguidor= '$idSeguidor' AND idSeguido='$idSeguido' ";
                if ($respuesta = $conexion->ejecutarInstruccion($sql)) {
                    echo json_encode(array("error" => false, "idSeguido" => $idSeguido, "mensaje" => "Se ha eliminado de sus favoritos"));
                } else {
                    echo json_encode(array("error" => true, "mensaje" => "fallo consulta de DELETE"));
                }
            }
            $conexion->cerrarConexion();
        } else {
            echo json_encode(array("error" => true, "mensaje" => "No hay idUsuario"));
        }
        break;

    case '13':
        session_start();
        $idAnuncio = $_SESSION["usuario"]["idAnuncio"];
        if (isset($_POST["valoracion"])) {
            $estrellas = $_POST["valoracion"];
        }
        $respuesta="";
        if ($estrellas == "" | $estrellas == NULL) {
            $respuesta.="valoración del anuncio";
        }
        if (isset($_POST["razónDenuncia"])) {
            $denuncia = $_POST["razónDenuncia"];
        }
        if ($denuncia == "" | $denuncia == NULL) {
            echo json_encode(array("error" => true, "mensaje" => "Justifique con una razón su valoración"));
        }
         else {
            $conexion = new conexion();
            $sql = "INSERT INTO calificacionanuncio (idAnuncios, valoracion) VALUES ($idAnuncio, $estrellas);";
            $respuesta = $conexion->ejecutarInstruccion($sql);
            $sql = "INSERT INTO denuncias (idrazonDenuncia,idAnuncios,comentarios) VALUES ('$denuncia', $idAnuncio,(SELECT descripcion FROM razondenuncia WHERE idrazonDenuncia = '$denuncia'));";
            $respuesta = $conexion->ejecutarInstruccion($sql);
            if (!$respuesta) {
                echo json_encode(array("error" => true, "mensaje" => "Error al enviar la denuncia"));
            } else {
                echo json_encode(array("error" => false, "mensaje" => "Gracias por tu opinión es valiosa, para nosotros es muy valiosa"));
            }
            $conexion->cerrarConexion();
        }

        break;
}
