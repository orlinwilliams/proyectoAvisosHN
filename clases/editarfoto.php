<?php
    require_once("conexion.php");

    switch($_GET['accion']){
        case '1':       //MIS PUBLICACIONES
            $conexion = new conexion();
            session_start();
            $idUsuario=$_SESSION["usuario"]["idUsuario"];
            if(isset($_POST["txt_idanuncios"])){                                                                            //Comienza a asignar las variables POST
                $idanuncios = $_POST["txt_idanuncios"];
              
            }
            $sql="SELECT idAnuncios, idUsuario, nombre, anuncios.idCategoria, nombreCategoria, descripcion, estadoArticulo 
            FROM anuncios INNER JOIN categoria ON categoria.idcategoria= anuncios.idcategoria 
            WHERE idUsuario=$idUsuario and idAnuncios=$idanuncios";//CONSULTA
            
            if($respuesta=$conexion->ejecutarInstruccion($sql)){
                if($respuesta->num_rows!=0){
                    $datos=$respuesta->fetch_assoc();
                    $sql1="SELECT localizacion, size ,nombre FROM fotos WHERE idAnuncios='$idanuncios'";
                    if($resultado=$conexion->ejecutarInstruccion($sql1)){

                            $sql4="SELECT precio FROM  anuncios WHERE idUsuario=$idUsuario and idAnuncios=$idanuncios ";
                            if($respuesta2=$conexion->ejecutarInstruccion($sql4)){
                                if($respuesta2->num_rows!=0){
                                    $precios=array();
                                    while($row1=$respuesta2->fetch_assoc()){
                                            $precio1=$row1["precio"];
                                            $division = explode(" ", $precio1);
                                            $moneda=$division[0];
                                            $precioReal=$division[1];
                                            //$precios[]=array("precio"=>$precioReal,"moneda"=>$moneda);
                                            //$libro = (object)$precios;
                                    }
                                }
                            }
                                
                            $fotos=array();
                            while($row=$resultado->fetch_array()){   
                                $fotos[]=array("path"=>$row["localizacion"],"size"=>$row["size"],"name"=>$row["nombre"]);
                           }
                           echo json_encode(array("info"=>$datos,"moneda"=>$moneda,"price"=>$precioReal,"info"=>$datos,"fotos"=>$fotos));   
                    }
                    else{
                        echo"error en consulta de fotos";
                    } 
                }
                else {
                    echo "NO hay anuncio";
                }
            }
            else {
                echo" Error en consultar datos de anuncio";
            }
            $conexion->cerrarConexion();
        break;

        case'2':
            $conexion=new conexion();
            if(isset($_POST["nombre"])){
                $nombreImagen=$_POST["nombre"];
                if(isset($_POST["id"])){
                    $idanuncio=$_POST["id"];

                    $sql="SELECT COUNT(*) as cantidadImages FROM fotos WHERE idAnuncios='$idanuncio'";
                    if($respuesta=$conexion->ejecutarInstruccion($sql)){
                        $row=$respuesta->fetch_assoc();
                        if($row["cantidadImages"]<=1){
                            echo json_encode(array("error"=>true,"mensaje"=>"No se puede eliminar esta imagen, el anuncio debe tener al menos una imagen"));
                        }
                        else{
                            $sql1= "DELETE FROM fotos WHERE nombre='$nombreImagen' AND idAnuncios='$idanuncio'";
                            if($conexion->ejecutarInstruccion($sql1)){
                                echo json_encode(array("error"=>false,"mensaje"=>"La imagen ha sido eliminada"));
                            }
                            else{  echo json_encode(array("error"=>true,"mensaje"=>" error en consulta de borrar"));
                            }    
                        }

                    }
                    else{
                        echo json_encode(array("error"=>true,"mensaje"=>" error en consulta cantidad de imagenes"));
                    }

                }
                else{
                    echo json_encode(array("error"=>true,"mensaje"=>"No hay Id"));
                }

            }
            else{
                echo json_encode(array("error"=>true,"mensaje"=>" error no hay nombre"));
            }
            $conexion->cerrarConexion();
        break;

        case'3':
            $conexion=new conexion();
            if(isset($_POST["idAnuncio"])){
                $idAnuncio=$_POST["idAnuncio"];
            }
            else{
                echo "no hay idAnuncio";
            }

            if($_FILES){
            echo print_r($_FILES); 
            }
            else{
                echo "no hay imagenes";
            }

            $imagenArchivo=$_FILES["file"]["tmp_name"];
            $nombreImagen=$_FILES["file"]["name"];
            $sizeImagen=$_FILES["file"]["size"];
            
            session_start();
            $usuario=$_SESSION["usuario"]["correoElectronico"];
            
            $carpetaFoto="fotosAnuncio/";
            $ruta=array();
            $sqlArray=array();
                for($i=0;$i<count($nombreImagen);$i++){
                    $ruta[$i]="../images/".$carpetaFoto.$usuario."/".$nombreImagen[$i];
                    
                    $sqlArray[$i]="INSERT INTO fotos (idAnuncios,nombre,localizacion,size) values ('$idAnuncio','$nombreImagen[$i]','$ruta[$i]','$sizeImagen[$i]')";
                        if($conexion->ejecutarInstruccion($sqlArray[$i])){
                            if(!move_uploaded_file($imagenArchivo[$i],$ruta[$i])){
                            $conexion->cerrarConexion();
                            echo " Error en foto: ".$nombreImagen[$i];
                            }

                        }
                        else{
                            echo json_encode(array("error"=>true, "mensaje"=>"eror en recorrido de consultas"));
                        }                      
                }
                $conexion->cerrarConexion();        
                echo json_encode(array("error"=>false, "mensaje"=>"imagenes agregadas correctamente"));
    }
