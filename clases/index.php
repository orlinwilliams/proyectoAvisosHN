<?php
require_once("conexion.php");
require_once("correo.php");

switch ($_GET["accion"]) {                                                                                      //Inicio de switch
    case '1':                                                                                                   //Llena el select de municipios
        $conexion = new conexion();
        $sql = "SELECT iddepartamentos, nombredepartamento FROM `departamentos`
            ORDER by iddepartamentos ASC;";
        $resultado = $conexion->ejecutarInstruccion($sql);
        if (!$resultado) {
            echo "No hay municipios";
        } else {
            echo '<option value="">Seleccione un municipio</option>';
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

    case '2':                                                                                                   //Registrar usuario

        if (isset($_POST["txt_nombre"])) {                                                                            //Comienza a asignar las variables POST
            $nombre = $_POST["txt_nombre"];
        }
        if (isset($_POST["txt_apellido"])) {
            $apellido = $_POST["txt_apellido"];
        }
        if (isset($_POST["date_fecha"])) {
            $fecha = $_POST["date_fecha"];
        }
        if (isset($_POST["txt_correo"])) {
            $correo = $_POST["txt_correo"];
        }
        if (isset($_POST["txt_tefelono"])) {
            $telefono = $_POST["txt_tefelono"];
        }
        if (isset($_POST["int_municipio"])) {
            $idMunicipio = $_POST["int_municipio"];
        }
        if (isset($_POST["txt_contraseña"])) {
            $contraseña = $_POST["txt_contraseña"];
        }
        if (isset($_POST["txt_contraseña2"])) {
            $contraseña2 = $_POST["txt_contraseña2"];
        }                                                                                                       //Fin de la asignación

        if ($nombre == "" || $nombre == NULL) {                                                                       //Comienza a vericar que no sean valores nulos o vacios
            $respuesta = "Ingrese el nombre";
            echo $respuesta;
        }
        if ($apellido == "" || $apellido == NULL) {
            $respuesta = "Ingrese el apellido";
            echo $respuesta;
        }
        if ($fecha == "" || $fecha == NULL) {
            $respuesta = "Ingrese la fecha";
            echo $respuesta;
        }
        if ($correo == "" || $correo == NULL) {
            $respuesta = "Ingrese el correo";
            echo $respuesta;
        }
        if ($telefono == "" || $telefono == NULL) {
            $respuesta = "Ingrese el telefono";
            echo $respuesta;
        }
        if ($idMunicipio == "" || $idMunicipio == NULL) {
            $respuesta = "Ingrese el municipio";
            echo $respuesta;
        }
        if ($contraseña == "" || $contraseña == NULL) {
            $respuesta = "Ingrese la contraseña";
            echo $respuesta;
        } else if ($contraseña2 == "" || $contraseña2 == NULL) {
            $respuesta = "Ingrese la contraseña";
            echo $respuesta;
        }                                                                                                         //Fin de validación
        else {
            $date = str_replace('/', '-', $fecha);                                                                //Sustituimos caracterés / por -
            $fecha = date('Y-m-d', strtotime($date));                                                             //Cambiamos el formato de la fecha
            $conexion = new Conexion();
            //Llamada al procedimiento almacenado
            $sql = "CALL `SP_REGISTRAR`('$nombre', '$apellido', '$correo', '$contraseña', '$contraseña2', '$telefono', '$fecha', 'null', 'null', '$idMunicipio', @p10);";

            $salida = "SELECT @p10 AS `mensaje`;";                                                                //Llamado al parametro de salida del procedimiento almacenado
            $resultado = $conexion->ejecutarInstruccion($sql);
            $respuesta = $conexion->ejecutarInstruccion($salida);
            if (!$respuesta) {
                echo "No hay respuesta del procedimiento";
            } else {
                $fila = $conexion->obtenerFila($respuesta);

                $token = uniqid(); //CONFIGURACION DE CONTENIDO DE CORREO ELECTRONICO
                $nombreServer = $_SERVER['SERVER_NAME'];
                $link = "<a href='http://$nombreServer/AvisosHN/clases/validar-usuario.php?token=$token'>AQUI</a><br>"; //LINK AL QUE INGRESERA EL USUARIO
                $mensajeEncabezado = "<br>Bienvenido a AvisosHN<br><br>";
                $mensaje = $mensajeEncabezado . "Para poder acceder a todas las caracteristicas de nuestra plataforma <br> 
                    confirme su cuenta " . $link;

                $sql2 = "UPDATE usuario SET token='$token' WHERE correoElectronico='$correo'";
                if ($conexion->ejecutarInstruccion($sql2)) { //ACTUALIZA EL TOKEN
                    $correo = new Correo($correo, $nombre, "Confirmacion de usuario", $mensaje);
                    if ($correo->enviarCorreo()) { //SE ENVIA CORREO
                        echo $fila["mensaje"] . ". Por favor revisa tu correo eléctronico para poder confirmar tu cuenta";
                    } else {
                        echo "FALLO EN ENVIO DE CORREO";
                    }
                } else {
                    echo "ERROR EN ACTUALIZAR TOKEN";
                }
            }

            $conexion->cerrarConexion();
        }
        break;
    case '3':

        if (isset($_POST["correo"])) {                                                                            //Comienza a asignar las variables POST
            $correo = $_POST["correo"];
        }
        if (isset($_POST["password"])) {
            $password = $_POST["password"];
        }
        if ($correo == "" || $correo == NULL) {
            $respuesta = "Ingrese el correo";
            echo $respuesta;
        } else if ($password == "" || $password == NULL) {
            $respuesta = "Ingrese la contraseña";
            echo $respuesta;
        }
        $conexion = new conexion();
        $sql = "SELECT idUsuario, pNombre, pApellido, correoElectronico, numTelefono,
            fechaRegistro, fechaNacimiento, urlFoto, RTN, tipousuario, idMunicipios, estado FROM `usuario`
            INNER JOIN tipousuario ON tipousuario.idtipoUsuario=usuario.idtipoUsuario
            WHERE correoElectronico='$correo' AND contrasenia='$password';";
        $resultado = $conexion->ejecutarInstruccion($sql);
        if ($resultado->num_rows == 1) {
            $datos = $resultado->fetch_assoc();
            session_start();
            $_SESSION["usuario"] = $datos;
            echo json_encode(array('error' => false, 'estado' => $datos['estado']));
        } else {
            echo json_encode(array('error' => true));
        }
        $conexion->cerrarConexion();
        break;
    case '4':

        if (isset($_POST["correo"])) {
            $correoUsuario = $_POST["correo"];
            $conexion = new conexion();

            $sql = "SELECT pNombre,correoElectronico FROM usuario WHERE correoElectronico='$correoUsuario'"; //verifica si existe el correo
            if ($query = $conexion->ejecutarInstruccion($sql)) {
                if ($query->num_rows == 1) {
                    $resultado = $query->fetch_assoc(); //consulta los valores del usuario
                    $token = uniqid();
                    $sql2 = "UPDATE usuario SET token='$token' WHERE correoElectronico='$correoUsuario'"; // actualiza del token en la base de datos
                    if ($query1 = $conexion->ejecutarInstruccion($sql2)) {

                        $nombreServer = $_SERVER['SERVER_NAME'];
                        //CONTENIDO DEL MENSAJE
                        $link = "<a href='http://$nombreServer/AvisosHN/clases/actualizar-password.php?token=$token'>AQUI</a><br>";
                        $mensaje2 = " el link solo puede ser utilizado una vez";

                        $mensaje = "<br> Ha olvidado su Password?<br> para poder restablecerla ingrese: " . $link . $mensaje2;

                        $correo = new Correo($correoUsuario, $resultado["pNombre"], "Recuperar Password", $mensaje); //parametros que lleva el correo
                        if ($correo->enviarCorreo()) { //SE envia el correo
                            echo json_encode(array("error" => false, "correo" => $correoUsuario));
                        } else {
                            echo json_encode(array("error" => true, "mensaje" => "no se envio el correo"));   //Manejo de posibles errores 
                        }
                    } else {
                        echo json_encode(array("error" => true, "mensaje" => "fallo en actualizar token"));
                    }
                } else {
                    echo json_encode(array("error" => true, "mensaje" => "No se encontro el correo"));
                }
            } else {
                echo json_encode(array("error" => true, "mensaje" => "Error en consulta de correo"));
            }
        } else {
            echo json_encode(array("error" => true, "mensaje" => "Correo Vacio"));;
        }
        $conexion->cerrarConexion();
        break;

    case '5':       // PUBLICACIONES INICIO
        $conexion = new conexion();
        $sql = "SELECT idAnuncios,nombre,precio,descripcion 
                  FROM anuncios ORDER BY idAnuncios DESC"; //CONSULTA PUBLICACIONES INICIO
        if ($resultado = $conexion->ejecutarInstruccion($sql)) {
            if ($resultado->num_rows != 0) {
                $datos = array();
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
                                $fotos[] = str_replace("../", " ", $row1["localizacion"]);
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
                //for($i=0; $i<count($datos); $i++){
                //    $datos[$i]["fotos"]=array("f1","f2");
                //}
                echo json_encode($datos);
            } else {
                echo json_encode(array("error" => true, "mensaje" => "No hay anuncios"));
            }
        } else {
            echo json_encode(array("error" => true, "mensaje" => "fallo en la consulta"));
        }
        $conexion->cerrarConexion();

        break;
}
