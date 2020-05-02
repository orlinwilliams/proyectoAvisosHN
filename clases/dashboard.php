<?php
    require_once("conexion.php");

    switch($_GET['accion']){ //DATOS DEL DIA
        case '1':
            $conexion = new conexion();
            $sqlUsuarios="SELECT COUNT(*) AS cantidadUsuarios  FROM usuario WHERE LEFT(fechaRegistro,10)=CURDATE()";
            $sqlAnuncios="SELECT COUNT(*) AS cantidadAnuncios FROM anuncios WHERE LEFT(fechaPublicacion,10)=CURDATE()";
            //$sqlAnuncios="SELECT COUNT(*) FROM denuncias WHERE fechaRegistro=now()";
            //$sqlAnuncios="SELECT COUNT(*) FROM comentarios WHERE fechaRegistro=now()";
            $cantidadUsuarios;
            $cantidadAnuncios;
            if($resultado1=$conexion->ejecutarInstruccion($sqlUsuarios)){
                $fila=$resultado1->fetch_assoc();
                $cantidadUsuarios=$fila["cantidadUsuarios"];
            }
            else{
                echo "error en consulta USUARIOS ";
            }
            if($resultado2=$conexion->ejecutarInstruccion($sqlAnuncios)){
                $fila2=$resultado2->fetch_assoc();
                $cantidadAnuncios=$fila2["cantidadAnuncios"];
            }
            else{
                echo "error en consulta anuncios ";
            }
            echo json_encode(array("cantidadUsuarios"=>$cantidadUsuarios,"cantidadAnuncios"=>$cantidadAnuncios));


        break;

        case '2':// DATOS DE INICIO
            
        break;

        case '2':// DATOS A COMPARAR
            
        break;


    }
?>