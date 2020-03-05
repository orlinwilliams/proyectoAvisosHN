<?php
require_once("conexion.php");

$correo =$_POST["correo"];
$password=$_POST["password"];
$requestDB=new conexion();

sleep(0.5);

$consult="SELECT *FROM USUARIO WHERE correoElectronico='$correo' and contrasena='$password'";

if($result=$requestDB->ejecutarInstruccion($consult)){
    if($result->num_rows==1){
        
        echo "1";
    }
    else{
        echo "2";
    }
}
else{
    echo "2";
}
