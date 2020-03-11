<?php
    require_once("conexion.php");
    require_once("correo.php");

    switch ($_GET["accion"]) {                                                                                      //Inicio de switch
        case '1':                                                                                                   //Llena el select de municipios
            $conexion = new conexion();
            $sql="SELECT iddepartamentos, nombredepartamento FROM `departamentos`
            ORDER by iddepartamentos ASC;";
            $resultado=$conexion->ejecutarInstruccion($sql);
            if(!$resultado){
                echo "No hay municipios";
            }
            else{
                echo '<option value="">Seleccione un municipio</option>';
                while($fila=$conexion->obtenerFila($resultado)){                                                    //Recorre todas las filas de departamentos
                    $iddepartamento=$fila["iddepartamentos"];
                    echo '<optgroup label="'.$fila["nombredepartamento"].'">';

                    $sql2="SELECT idmunicipios, municipio FROM `municipios`
                    WHERE iddepartamentos=$iddepartamento
                    ORDER by idmunicipios ASC;";                                                                    //Por cada departamento consultará los municipios que pertenecen al departamento

                    $resultado2=$conexion->ejecutarInstruccion($sql2);
                    if($resultado2){
                        while($fila2=$conexion->obtenerFila($resultado2)){                                          //Recorre todas las filas de municipio según el departamento
                            echo'<option value="'.$fila2["idmunicipios"].'">'.$fila2["municipio"].'</option>';
                        }
                    }
                    echo '</optgroup>';
                }
            }
            $conexion->liberarResultado($sql);
            $conexion->liberarResultado($sql2);
            $conexion->cerrarConexion();
        break;

        case '2':                                                                                                   //Registrar usuario
            
            if(isset($_POST["txt_nombre"])){                                                                            //Comienza a asignar las variables POST
                $nombre = $_POST["txt_nombre"];
            }
            if(isset($_POST["txt_apellido"])){
                $apellido = $_POST["txt_apellido"];
            }
            if(isset($_POST["date_fecha"])){
                $fecha = $_POST["date_fecha"];
            }
            if(isset($_POST["txt_correo"])){
                $correo = $_POST["txt_correo"];
            }
            if(isset($_POST["txt_tefelono"])){
                $telefono = $_POST["txt_tefelono"];
            }
            if(isset($_POST["int_municipio"])){
                $idMunicipio = $_POST["int_municipio"];
            }
            if(isset($_POST["txt_contraseña"])){
                $contraseña = $_POST["txt_contraseña"];
            } 
            if(isset($_POST["txt_contraseña2"])){
                $contraseña2 = $_POST["txt_contraseña2"];
            }                                                                                                       //Fin de la asignación
            
            if($nombre=="" || $nombre==NULL){                                                                       //Comienza a vericar que no sean valores nulos o vacios
                $respuesta="Ingrese el nombre";
                echo $respuesta;
            }
            if($apellido=="" || $apellido==NULL){
                $respuesta="Ingrese el apellido";
                echo $respuesta;
            }
            if($fecha=="" || $fecha==NULL){
                $respuesta="Ingrese la fecha";
                echo $respuesta;
            }
            if($correo=="" || $correo==NULL){
                $respuesta="Ingrese el correo";
                echo $respuesta;
            }
            if($telefono=="" || $telefono==NULL){
                $respuesta="Ingrese el telefono";
                echo $respuesta;
            }
            if($idMunicipio=="" || $idMunicipio==NULL){
                $respuesta="Ingrese el municipio";
                echo $respuesta;
            }
            if($contraseña=="" || $contraseña==NULL){
                $respuesta="Ingrese la contraseña";
                echo $respuesta;
            }
            else if($contraseña2=="" || $contraseña2==NULL){
                $respuesta="Ingrese la contraseña";
                echo $respuesta;
            }                                                                                                         //Fin de validación
            else{
                $date = str_replace('/', '-', $fecha);                                                                //Sustituimos caracterés / por -
                $fecha = date('Y-m-d', strtotime($date));                                                             //Cambiamos el formato de la fecha
                $conexion = new Conexion();
                //Llamada al procedimiento almacenado
                $sql = "CALL `SP_REGISTRAR`('$nombre', '$apellido', '$correo', '$contraseña', '$contraseña2', '$telefono', '$fecha', 'null', 'null', '$idMunicipio', @p10);";

                $salida = "SELECT @p10 AS `mensaje`;";                                                                //Llamado al parametro de salida del procedimiento almacenado
                $resultado = $conexion->ejecutarInstruccion($sql);
                $respuesta = $conexion->ejecutarInstruccion($salida);
                if(!$respuesta){
                    echo "No hay respuesta del procedimiento";
                }
                else{
                    $fila=$conexion->obtenerFila($respuesta);
                    echo $fila["mensaje"];
                    $correo= new Correo($correo,$nombre);
                    $correo->enviarCorreo();

                }

                $conexion->cerrarConexion();
            }
        break;

        case '3':
            
            if(isset($_POST["correo"])){                                                                            //Comienza a asignar las variables POST
                $correo = $_POST["correo"];
            }
            if(isset($_POST["password"])){
                $password = $_POST["password"];
            }
            if($correo=="" || $correo==NULL){
                $respuesta="Ingrese el correo";
                echo $respuesta;
            }
            else if($password=="" || $password==NULL){
                $respuesta="Ingrese la contraseña";
                echo $respuesta;
            }
            $conexion = new conexion();
            $sql="SELECT idUsuario, pNombre, pApellido, correoElectronico, numTelefono,
            fechaRegistro, fechaNacimiento, urlFoto, RTN, tipousuario, idMunicipios FROM `usuario`
            INNER JOIN tipousuario ON tipousuario.idtipoUsuario=usuario.idtipoUsuario
            WHERE correoElectronico='$correo' AND contrasenia='$password';";
            $resultado=$conexion->ejecutarInstruccion($sql);
            if($resultado->num_rows==1){
                $datos=$resultado->fetch_assoc();
                session_start();
                $_SESSION["usuario"] = $datos;
                echo json_encode(array('error'=>false, 'tipo' => $datos['tipousuario']));
            }
            else{
                echo json_encode(array('error'=>true));
            }
            $conexion->cerrarConexion();
        break;
    }