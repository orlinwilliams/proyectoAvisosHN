<?php
    
    require_once("conexion.php");
    if(isset($_GET['token'])){ //valida que exista el token y que sea correcto

        $token=$_GET['token'];
        $sql1="SELECT idUsuario,pNombre FROM usuario WHERE token='$token'";
        $conexion = new conexion();
        if($query=$conexion->ejecutarInstruccion($sql1)){
            if($query->num_rows==1){
                $resultado=$query->fetch_assoc();
                $idUsuario=$resultado["idUsuario"];
                
                $sql2="UPDATE usuario SET token=null WHERE idUsuario='$idUsuario'"; //Actualiza el token a null por seguridad
                if($conexion->ejecutarInstruccion($sql2)){
                    session_start();
                    $_SESSION["correo"]=$resultado;//inicia sesion para poder capturar el id posteriormente
                    $conexion->cerrarConexion();
                    
                    header("location:../vistas/actualizar-contraseña.php");
                }
                else{
                    echo "Error en actualizar el Token"; //validaciones y posibles errores
                    
                }
            }
            else{
                //echo "<h1> TOKEN INVALIDO</h1>"."<br><p>El link solo puede utilizarse una vez</p>";
                //sleep(1);
                header("location:../index.php");
                $conexion->cerrarConexion();
            }
        }
        else{
            echo "Error en la consulta";
        }
        //$conexion->cerrarConexion();
    }
    else{
        header("location:../index.php");
        //echo "No esta el token";
    }