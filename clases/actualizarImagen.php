<?php
require_once("conexion.php");
//echo "EN EL SERVER";
$imagenArchivo=$_FILES["imagen"]["tmp_name"];
$nombreImagen=$_FILES["imagen"]["name"];
session_start();


if(isset($imagenArchivo) && isset($nombreImagen)){
    $idUsuario=$_SESSION["usuario"]["idUsuario"];
    $carpeta="imgUsuarios/";
    $ruta="../images/".$carpeta.$nombreImagen;
    move_uploaded_file($imagenArchivo,$ruta);
    $conexion = new conexion();
    $consulta="UPDATE usuario SET urlFoto='$ruta' WHERE idUsuario='$idUsuario'";
    
    if($conexion->ejecutarInstruccion($consulta)){
        echo $ruta;
        $conexion->cerrarConexion();

    }
    else{
        echo"ERROR EN CONSULTA";
        $conexion->cerrarConexion();
    }

}
else{
    echo "ERROR EN LOS DATOS";
    $conexion->cerrarConexion();
}

