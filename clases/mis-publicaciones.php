<?php
    require_once("conexion.php");

    switch($_GET['accion']){
        case '4':                   //Eliminar anuncio publicado
            echo 'Hola q ace';
        break;
        case '5'://MIS PUBLICACIONES
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
        case '6':                                                                                                   //Actualizar datos del anunicio
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