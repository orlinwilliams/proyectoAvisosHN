<?php
    require_once("conexion.php");

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
            if(isset($_POST["estado"])){
                $estado = $_POST["estado"];
            }
            if(isset($_POST["descripcion"])){
                $descripcion = $_POST["descripcion"];
            }                                                                                                     
            
            if($nombre=="" || $nombre==NULL){                                                                      
                $respuesta="Ingrese el nombre";
                echo $respuesta;
            }
            if($precio=="" || $precio==NULL){
                $respuesta="Ingrese el precio";
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
            
            session_start();
            $idUsuario=$_SESSION["usuario"]["idUsuario"];
            $idMunicipio=$_SESSION["usuario"]["idMunicipios"];
            $usuario=$_SESSION["usuario"]["correoElectronico"];
            
            $carpetaFoto="fotosAnuncio/";
            
           
            $sql = "CALL `SP_PUBLICAR_ANUNCIO`('$idUsuario','$idCategoria','$idMunicipio','$nombre','$precio','$estado','$descripcion',@p7);";
            
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
                        
                            $sqlArray[$i]="INSERT INTO fotos (idAnuncios,localizacion) values ('$lastId','$ruta[$i]')";
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
                echo "Error P. almacenado"." nombre:".$nombre." precio: ".$precio." idCategoria: ".$idCategoria."estado: ".$estado."descripcion: ".$descripcion."idUsuario: ".$idUsuario."idMunicipio".$idMunicipio;
            }            
                
        break;
  

        case '4': //Eliminar anuncio publicado beta
            echo 'Hola q ace';
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
                    //for($i=0; $i<count($datos); $i++){
                    //    $datos[$i]["fotos"]=array("f1","f2");
                    //}
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
            if(isset($_POST["nombre_articulo"])){                                                                            //Comienza a asignar las variables POST
                $nombre_articulo = $_POST["nombre_articulo"];
            }
            if(isset($_POST["precio"])){                                                                            //Comienza a asignar las variables POST
                $precio = $_POST["precio"];
            }
            if(isset($_POST["estado"])){
                $estado = $_POST["estado"];
            }
            if(isset($_POST["categoria"])){
                $categoria = $_POST["categoria"];
            }
            if(isset($_POST["descripcion"])){
                $descripcion = $_POST["descripcion"];
            }
            
            if($nombre_articulo=="" || $nombre_articulo==NULL){
                $respuesta="Ingrese el nombre del articulo";
                echo $respuesta;
            }
            
            if($precio=="" || $precio==NULL){
                $respuesta="Ingrese el precio.";
                echo $respuesta;
            }
            if($estado=="" || $estado==NULL){
                $respuesta="Ingrese la estado.";
                echo $respuesta;
            }
            if($categoria=="" || $categoria==NULL){
                $respuesta="Ingrese la categoria";
                echo $respuesta;
            }                                                                                                        //Fin de validación
            else{
                $conexion = new conexion();
                session_start();
                $idUsuario = $_SESSION["usuario"]["idUsuario"];
                
                $sql="CALL `SP_EDITAR_ANUNCIO`('$idanuncios','$idUsuario','$categoria','$precio','$nombre_articulo','$descripcion','$estado', @p8, @p9);";
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
                    $datos=array();
                    while($row=$respuesta->fetch_array()){
                        $datos[]=array("idAnuncios"=>$row["idAnuncios"],"idUsuario"=>$row["idUsuario"],"nombre"=>$row["nombre"],
                        "precio"=>$row["precio"],"nombreCategoria"=>$row["nombreCategoria"],"estadoArticulo"=>$row["estadoArticulo"],"descripcion"=>$row["descripcion"]);
                        
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