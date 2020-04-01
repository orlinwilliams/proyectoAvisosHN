<?php
    require_once("conexion.php");

    switch ($_GET["accion"]) {                                                                                      //Inicio de switch
        case '1':                                                                                                   //Actualizar datos
            if(isset($_POST["txt_nombre"])){                                                                            //Comienza a asignar las variables POST
                $nombre = $_POST["txt_nombre"];
            }
            if(isset($_POST["txt_apellido"])){
                $apellido = $_POST["txt_apellido"];
            }
            if(isset($_POST["txt_correo"])){
                $correo = $_POST["txt_correo"];
            }
            if(isset($_POST["date_fecha"])){
                $fecha = $_POST["date_fecha"];
            }
            if(isset($_POST["int_municipio"])){
                $idMunicipio = $_POST["int_municipio"];
            }
            if(isset($_POST["txt_tefelono"])){
                $telefono = $_POST["txt_tefelono"];
            }
            if($nombre=="" || $nombre==NULL){                                                                       //Comienza a vericar que no sean valores nulos o vacios
                $respuesta="Ingrese el nombre";
                echo $respuesta;
            }
            if(isset($_POST["txt_rtn"])){
                $rtn = $_POST["txt_rtn"];
            }
            if($apellido=="" || $apellido==NULL){
                $respuesta="Ingrese el apellido";
                echo $respuesta;
            }
            if($correo=="" || $correo==NULL){
                $respuesta="Ingrese el correo";
                echo $respuesta;
            }
            if($fecha=="" || $fecha==NULL){
                $respuesta="Ingrese la fecha";
                echo $respuesta;
            }
            if($telefono=="" || $telefono==NULL){
                $respuesta="Ingrese el telefono";
                echo $respuesta;
            }                                                                                                        //Fin de validación
            else{
                session_start();
                $idUsuario = $_SESSION["usuario"]["idUsuario"];
                $date = str_replace('/', '-', $fecha);                                                                //Sustituimos caracterés / por -
                $fecha = date('Y-m-d', strtotime($date));   
                $conexion = new conexion();
                $sql="CALL `SP_EDITAR_USUARIO`('$idUsuario', '$nombre', '$apellido', '$fecha', '$correo', '$telefono', '$idMunicipio', '$rtn', @p8, @p9);";
                $salida = "SELECT @p9 AS `pcMensaje`;";
                $resultado = $conexion->ejecutarInstruccion($sql);
                $respuesta = $conexion->ejecutarInstruccion($salida);
                if(!$respuesta){
                    echo "No hay respuesta del procedimiento";
                }
                else{
                    $fila=$conexion->obtenerFila($respuesta);
                    echo $fila["pcMensaje"];
                    
                    $sql="SELECT idUsuario, pNombre, pApellido, correoElectronico, numTelefono,
                    fechaRegistro, fechaNacimiento, urlFoto, RTN, tipousuario, idMunicipios FROM `usuario`
                    INNER JOIN tipousuario ON tipousuario.idtipoUsuario=usuario.idtipoUsuario
                    WHERE correoElectronico='$correo' AND idUsuario=$idUsuario";
                    $resultado=$conexion->ejecutarInstruccion($sql);
                    if($resultado->num_rows==1){
                        $datos=$resultado->fetch_assoc();
                        $_SESSION["usuario"] = $datos;
                    }
                    else{
                    }
                }
                $conexion->cerrarConexion();
            }                                              
        break;
        case '2':
            if(isset($_POST["contraseñaActual"])){
                $contraseñaActual = $_POST["contraseñaActual"];
            }
            if($contraseñaActual=="" || $contraseñaActual==NULL){                                                                       //Comienza a vericar que no sean valores nulos o vacios
                $respuesta="Ingrese la contraseña actual";
                echo $respuesta;
            }
            if(isset($_POST["txt_contraseña"])){
                $contraseña = $_POST["txt_contraseña"];
            }
            if($contraseña=="" || $contraseña==NULL){
                $respuesta="Ingrese la nueva contraseña";
                echo $respuesta;
            }
            if(isset($_POST["txt_contraseña2"])){
                $contraseña2 = $_POST["txt_contraseña2"];
            }
            if($contraseña2=="" || $contraseña2==NULL){
                $respuesta="Por favor confirme la contraseña";
                echo $respuesta;
            }
            else{
                session_start();
                $idUsuario=$_SESSION["usuario"]["idUsuario"];
                $conexion = new conexion();
                $sql="CALL `SP_CONTRASENIA`('$idUsuario', '$contraseñaActual', '$contraseña', '$contraseña2', @p4, @p5);";
                $salida = "SELECT @p5 AS `pcMensaje`;";
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
        case '3'://RESTABLECER CONTRASEÑA
            if(isset($_POST["password2"]) && isset($_POST["confirm"])){
                $password1=$_POST["password2"];
                $password2=$_POST["confirm"];
                if($password1===$password2){//valida que las contraseñas sean iguales
                    session_start();
                    $conexion = new conexion();
                    if(isset($_SESSION["correo"]["idUsuario"])){
                        $idUsuario=$_SESSION["correo"]["idUsuario"];//capturo el id a traves de la sesion
                        $sql= "UPDATE usuario SET contrasenia='$password2' WHERE idUsuario='$idUsuario'";//se actualiza la contraseña
                        if($query=$conexion->ejecutarInstruccion($sql)){
                            $conexion->cerrarConexion();
                            session_destroy();
                            echo json_encode(array("error"=>false,"mensaje"=>"Password actualizada correctamente"));
                            
                        }
                        else{
                        echo json_encode(array('error'=>true,"mensaje"=>"Error en la consulta de actualizacion"));//manejo de posibles errores
                        }    
                    }
                    else{
                        echo json_encode(array('error'=>true,"mensaje"=>"No hay sesion")) ;
                    }
                    
                }
                else{
                    echo json_encode(array("error"=>true,"mensaje"=>"las contraseñas no coinciden favor revisar"));
                }
            }
            else{
                echo json_encode(array("error"=>true,"mensaje"=>" Ingrese contraseña")) ;
            }
            
        break;

        case '4': //ELIMINAR CUENTA DE USUARIO
            if(isset($_POST["txt_contrasenia_confi"])){
                $contrasenia = $_POST["txt_contrasenia_confi"];
            }
            if($contrasenia=="" || $contrasenia==NULL){                                                                     
                $respuesta="Ingrese la contraseña ";
                echo $respuesta;
            }
            else{
                session_start();
                $idUsuario=$_SESSION["usuario"]["idUsuario"];
                $conexion = new conexion();
                $sql="CALL `SP_ELIMINAR_USUARIO`('$idUsuario', '$contrasenia', @p4, @p5);";
                $salida = "SELECT @p5 AS `pcMensaje`;";
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
        case '5':       //MIS PUBLICACIONES
            $conexion = new conexion();
            session_start();
            $idUsuario=$_SESSION["usuario"]["idUsuario"];
            $sql="SELECT idAnuncios,idUsuario,nombre,precio,descripcion FROM anuncios WHERE idUsuario='$idUsuario'";//CONSULTA MIS PUBLICACIONES
            if($resultado=$conexion->ejecutarInstruccion($sql)){
                if($resultado->num_rows!=0){
                    $datos=array();
                    while($row=$resultado->fetch_array()){
                        $datos[]=array("idAnuncios"=>$row["idAnuncios"],"idUsuario"=>$row["idUsuario"],"nombre"=>$row["nombre"],
                        "precio"=>$row["precio"],"descripcion"=>$row["descripcion"]);
                        
                    }
                    echo json_encode($datos);
                    
                    


                }
                else{
                    echo json_encode(array("error"=>true,"mensaje"=>"No hay anuncios"));
                }
            }
            else{
                echo json_encode(array("error"=>true,"mensaje"=>"fallo en la consulta"));
            }
            $conexion->cerrarConexion();

        break;
    }