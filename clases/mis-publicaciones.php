<?php
    require_once("conexion.php");
    require_once("correo.php");

    switch($_GET['accion']){
        case '2': //PUBLICAR ANUNCIO
                                                                                                               
            if(isset($_POST["categoria"])){                                                                    
                $idCategoria = $_POST["categoria"];
            }
            if(isset($_POST["nombre"])){                                                                        
                $nombre = $_POST["nombre"];
            }
            if(isset($_POST["precio"])){
                $precio = $_POST["precio"];
            }
            if(isset($_POST["moneda"])){
                $moneda= $_POST["moneda"];
            }
            
            if(isset($_POST["estado"])){
                $estado = $_POST["estado"];
            }
            if(isset($_POST["descripcion"])){
                $descripcion = $_POST["descripcion"];
            }                                                                                                     
            if(isset($_POST["lugar"])){
                $lugar=$_POST["lugar"];
            }
            if($nombre=="" || $nombre==NULL){                                                                      
                $respuesta="Ingrese el nombre";
                echo $respuesta;
            }
            if($precio=="" || $precio==NULL){
                $respuesta="Ingrese el precio";
                echo $respuesta;
            }
            if($moneda=="" || $moneda==NULL){
                $moneda="Ingrese el moneda";
                echo $respuesta;
            }
            if($estado=="" || $estado==NULL){
                $respuesta="Ingrese el estado";
                echo $respuesta;
            }
            if(!isset($_FILES)){
                echo "Debe ingresar por lo menos una imagen";
            }
            
            $conexion = new conexion();
            $imagenArchivo=$_FILES["file"]["tmp_name"];
            $nombreImagen=$_FILES["file"]["name"];
            $sizeImagen=$_FILES["file"]["size"];
            
            session_start();
            $idUsuario=$_SESSION["usuario"]["idUsuario"]; 
            $idMunicipio=$_SESSION["usuario"]["idMunicipios"];
            $usuario=$_SESSION["usuario"]["correoElectronico"];
            
            $carpetaFoto="fotosAnuncio/";
            
           
            $sql = "CALL `SP_PUBLICAR_ANUNCIO`('$idUsuario','$idCategoria','$idMunicipio','$nombre',CONCAT('$moneda','$precio'),'$estado','$descripcion',@p7);";
            
            //ENVIO DE CORREOS A USUARIOS SEGUIDORES
            $idSeguido=$idUsuario;
            $nombreSeguido=$_SESSION["usuario"]["pNombre"] . ' ' . $_SESSION["usuario"]["pApellido"];

            $sql2="SELECT F.idSeguidor,concat_ws(' ',u.pnombre, u.papellido) as nombreSeguidor, correoElectronico  FROM favoritos as F 
            INNER JOIN usuario as U
            ON F.idSeguidor=U.idUsuario
            WHERE idSeguido='$idSeguido'";
            if($resultado2=$conexion->ejecutarInstruccion($sql2)){
                if($resultado2->num_rows!=0){
                    
                    $asunto="Nueva publicacion de ".$nombreSeguido;
                    $nombreServer = $_SERVER['SERVER_NAME'];
                    $link = "<a href='http://$nombreServer/AvisosHN/'>AQUI</a><br>"; //LINK AL QUE INGRESERA EL USUARIO
                    $mensaje="De parte del equipo de Marketh le notificamos que el vendedor ".$nombreSeguido." ha realizado una publicacion <br><br>
                    Nombre= $nombre<br>Estado= $estado <br>Descripcion= $descripcion<br><br> Para poder ver todos los detalles ingresa a nuestra plataforma 
                    puedes acceder haciendo click ".$link;
                    
                    while($row2=$conexion->obtenerFila($resultado2)) {
                        
                        $correo=new Correo($row2["correoElectronico"],$row2["nombreSeguidor"],$asunto,$mensaje);
                        if(!$correo->enviarCorreo()){
                            echo "ERROR EN ENVIO DE CORREO";
                        }    

                    }

                }

            }
            else{
                echo "ERROR EN CONSULTA DE SEGUIDORES";
            }

            
            
            
            if($resultadoProcedimiento = $conexion->ejecutarInstruccion($sql)){
                $carpetaUsuario="../images/".$carpetaFoto.$usuario;
                if (!file_exists($carpetaUsuario)) {
                    mkdir($carpetaUsuario, 0777, true);
                }
                                
                $sql1="SELECT MAX(idAnuncios) AS idAnuncio FROM Anuncios";
                if($resultadoIdAnuncio=$conexion->ejecutarInstruccion($sql1)){
                    $row=$resultadoIdAnuncio->fetch_array();
                    $lastId=$row["idAnuncio"];
                    
                    $ruta=array();
                    $sqlArray=array();
                    for($i=0;$i<count($nombreImagen);$i++){
                        $ruta[$i]="../images/".$carpetaFoto.$usuario."/".$nombreImagen[$i];
                        
                        $sqlArray[$i]="INSERT INTO fotos (idAnuncios,nombre,localizacion,size) values ('$lastId','$nombreImagen[$i]','$ruta[$i]','$sizeImagen[$i]')";
                            if($conexion->ejecutarInstruccion($sqlArray[$i])){

                                if(!move_uploaded_file($imagenArchivo[$i],$ruta[$i])){
                                $conexion->cerrarConexion();
                                echo " Error en foto: ".$nombreImagen[$i];
                                }

                            }
                            else{
                                echo "eror en recorrido de consultas";
                            }                      
                    }
                    $conexion->cerrarConexion();        
                    echo "Anuncio agregado correctamente";
                }
                else{
                    echo" no se obtuvo el ultimo id";
                }
                
            }
            else{
                echo "Error P. almacenado"." nombre:".$nombre." precio: ".$precio." moneda: ".$moneda." idCategoria: ".$idCategoria."estado: ".$estado."descripcion: ".$descripcion."idUsuario: ".$idUsuario."idMunicipio".$idMunicipio;
            }            
                
        break;
        case '4': //Eliminar anuncio publicado beta
            if(isset($_POST["txt_idanuncios"])){
                $idAnuncio=$_POST["txt_idanuncios"];
            }
            if($idAnuncio == "" || $idAnuncio == NULL){
                echo "ingrese el ID del anuncio";
            }
            if(isset($_POST["razon"])){
                $razon=$_POST["razon"];
            }
            if($razon == "" || $razon == NULL){
                echo "Ingrese la razón por la cual borra el anuncio";
            }
            else{
            $conexion = new conexion();
            session_start();
            $idUsuario=$_SESSION["usuario"]["idUsuario"];
            $sql="INSERT INTO razonborrado (razon) values ('$razon');";
            $resultado = $conexion->ejecutarInstruccion($sql);
            $sql = "CALL `SP_ELIMINAR_ANUNCIO`('$idAnuncio', '$idUsuario', @p3);";
            $salida = "SELECT @p3 AS `pcMensaje`;";
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
                    
                    //$idAnuncio=$datos["idAnuncios"];
                    $i=0;
                    while($row=$resultado->fetch_array()){

                        $datos[]=array("idAnuncios"=>$row["idAnuncios"],"idUsuario"=>$row["idUsuario"],"nombre"=>$row["nombre"],
                        "precio"=>$row["precio"],"descripcion"=>$row["descripcion"],"fotos"=>"");
                        
                        $idAnuncio=$row["idAnuncios"];

                        $sql1="SELECT localizacion FROM fotos WHERE idAnuncios='$idAnuncio'";
                        if($resultado1=$conexion->ejecutarInstruccion($sql1)){
                            if($resultado1->num_rows!=0){
                                
                                $fotos=array();
                                while($row1=$resultado1->fetch_array()){   
                                $fotos[]=$row1["localizacion"];
                            
                                }
                                $datos[$i]["fotos"]=$fotos;
                                $i++;
                                
                            
                            }
                            else{
                                echo "NO HAY FOTO ";
                                break;
                            }
                            
                        }
                        else{
                            echo "Fallo en la consulta de fotos";
                            break;
                        }
                        
                                
                    }
                    echo json_encode($datos) ; 
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
        case '6':              //Actualizar datos del anunicio
            if(isset($_POST["txt_idanuncios"])){                                                                            //Comienza a asignar las variables POST
                $idanuncios = $_POST["txt_idanuncios"];
            }
            if(isset($_POST["nombre"])){                                                                            //Comienza a asignar las variables POST
                $nombre_articulo = $_POST["nombre"];
            }
            if(isset($_POST["precio"])){                                                                            //Comienza a asignar las variables POST
                $precio = $_POST["precio"];
            }
            if(isset($_POST["moneda"])){                                                                            //Comienza a asignar las variables POST
                $moneda = $_POST["moneda"];
            }
            if(isset($_POST["estado"])){
                $estado = $_POST["estado"];
            }
            if(isset($_POST["categoriaAct"])){
                $idcategoria = $_POST["categoriaAct"];
            }
            if(isset($_POST["descripcion"])){
                $descripcion = $_POST["descripcion"];
            }
            if(isset($_POST["municipio"])){
                $municipio = $_POST["municipio"];
            }
            
            if($nombre_articulo=="" || $nombre_articulo==NULL){
                $respuesta="Ingrese el nombre del articulo";
                echo $respuesta;
            }
            
            if($precio=="" || $precio==NULL){
                $respuesta="Ingrese el precio.";
                echo $respuesta;
            }
            if($moneda=="" || $moneda==NULL){
                $respuesta="Ingrese el moneda";
                echo $respuesta;
            }
            if($estado=="" || $estado==NULL){
                $respuesta="Ingrese la estado.";
                echo $respuesta;
            }
            if($idcategoria=="" || $idcategoria==NULL){
                $respuesta="Ingrese la categoria";
                echo $respuesta;
            } 
            if($municipio=="" || $municipio==NULL){
                $respuesta="Ingrese el municipio";
                echo $respuesta;
            }
            //echo $idanuncios." ".$nombre_articulo." ".$precio." ".$moneda." ".$municipio." ".$estado." ".$idcategoria." ".$descripcion;                                                                                                     
            
            else{
                $conexion = new conexion();
                session_start();
                $idUsuario = $_SESSION["usuario"]["idUsuario"];
                //echo $idanuncios." ".$idUsuario." ".$nombre_articulo." ".$precio." ".$moneda." ".$municipio." ".$estado." ".$idcategoria." ".$descripcion;
                $sql="CALL `SP_EDITAR_ANUNCIO`('$idanuncios','$idUsuario','$idcategoria', '$municipio' ,CONCAT('$moneda ','$precio') ,'$nombre_articulo','$descripcion','$estado', @p8, @p9);";
                $salida = "SELECT @p9 AS `pcMensaje`;";
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
        case '7':                                                                                                   //mostar datos en modal del anuncio para editarlos
            $conexion = new conexion();
            session_start();
            $idUsuario=$_SESSION["usuario"]["idUsuario"];
            if(isset($_POST["txt_idanuncios"])){                                                                            //Comienza a asignar las variables POST
                $idanuncios = $_POST["txt_idanuncios"];
              
            }
            
            //echo $idAnuncios;
            $sql="SELECT idAnuncios, idUsuario, nombre, precio, nombreCategoria, descripcion, estadoArticulo 
            FROM anuncios INNER JOIN categoria ON categoria.idcategoria= anuncios.idcategoria 
            WHERE idUsuario=$idUsuario and idAnuncios=$idanuncios";//CONSULTA
            
            
            if($respuesta=$conexion->ejecutarInstruccion($sql)){
                if($respuesta->num_rows!=0){
                    
                    while($row=$respuesta->fetch_array()){
                        $datos=array();
                        $precio1=$row["precio"];
                        $division = explode(" ", $cprecio1);
                        $moneda=$division[0];
                        $precioReal=$division[1];
                        $datos[]=array("idAnuncios"=>$row["idAnuncios"],"idUsuario"=>$row["idUsuario"],"nombre"=>$row["nombre"],
                        "moneda"=>$moneda,"precio"=>$precioReal,"nombreCategoria"=>$row["nombreCategoria"],"estadoArticulo"=>$row["estadoArticulo"],"descripcion"=>$row["descripcion"]);
                        
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
?>