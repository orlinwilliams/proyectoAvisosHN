<?php
 echo 'Redireccionando';
    require_once("conexion.php");
    if(isset($_GET['token'])){

        $token=$_GET['token'];
        $sql1="SELECT idUsuario,urlFoto,pNombre FROM usuario WHERE token='$token'";
        $conexion = new conexion();
        if($query=$conexion->ejecutarInstruccion($sql1)){
            if($query->num_rows==1){
                $resultado=$query->fetch_assoc();
                $idUsuario=$resultado["idUsuario"];
                $sql2="UPDATE usuario SET token=null WHERE idUsuario='$idUsuario'"; //Actualizo el token a null 
                if($conexion->ejecutarInstruccion($sql2)){
                    session_start();
                    $_SESSION["correo"]=$resultado;
                    echo "Redireccionando...";
                    sleep(4);
                    header("location:../vistas/recuperar-contraseña.php");
                }
                else{
                    echo "Error en actualizar el Token";
                    
                }
            }
            else{
                echo "<h1> TOKEN INVALIDO</h1>"."<br><p>El link solo puede utilizarse una vez</p>";
                sleep(1);
                header("location:../index.php");
            }
        }
        else{
            echo "Error en la consulta";
        }
        $conexion->cerrarConexion();
    }
    else{
        //header("location:../index.php");
        echo "No esta el token";
    }