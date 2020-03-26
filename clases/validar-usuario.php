<?php
    require_once("conexion.php");
    if(isset($_GET['token'])){ //valida que exista el token

        $token=$_GET['token'];
        $sql1="SELECT idUsuario,pNombre FROM usuario WHERE token='$token'";
        $conexion = new conexion();
        if($query=$conexion->ejecutarInstruccion($sql1)){//verifica que el token no haya sido cambiado
            if($query->num_rows==1){
                $resultado=$query->fetch_assoc();
                $idUsuario=$resultado["idUsuario"];
                
                $sql2="UPDATE usuario SET token=null WHERE idUsuario='$idUsuario'"; //Actualiza el token a null por seguridad
                if($conexion->ejecutarInstruccion($sql2)){
                    $sql3="UPDATE usuario SET estado=1 WHERE idUsuario='$idUsuario'";
                    if($conexion->ejecutarInstruccion($sql3)){
                        $conexion->cerrarConexion();
                        header("location:../index.php");
                    }  
                    else{
                        echo "FALLO EN CAMBIO DE STATUS"; //validaciones y posibles errores
                    }
                    
                }
                else{
                    echo "Error en actualizar el Token";        
                }
            }
            else{
                
                header("location:../index.php");
                $conexion->cerrarConexion();
            }
        }
        else{
            //echo "Error en la consulta"; 
            header("location:../index.php");
        }
        
    }
    else{
        header("location:../index.php");
        //echo "No esta el token";
    }