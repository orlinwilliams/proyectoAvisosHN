<?php
 require_once("conexion.php");
switch ($_GET["accion"]){

    case '1':       //PUBLICACIONES FILTRADAS
        $where='';
                
        if (isset($_GET["flugar"])){ //si todos estan llenos
            $flugar=$_GET["flugar"];
            
            if (isset($_GET["fcategoria"])){
                $fcategoria=$_GET["fcategoria"];

                if (isset($_GET["valoracion"])){
                    $valoracion=$_GET["valoracion"];

                    if (isset($_GET["minimo"]) && isset($_GET["maximo"])){
                        $min=$_GET["minimo"];
                        $max=$_GET["maximo"];
                        
                               
                            if ($min==0 && $max>0 ){ //si campo de rango max es mayor a cero
                                
                                    $where="where c.idcategoria like $fcategoria
                                        AND m.idMunicipios like $flugar 
                                        AND cv.cantidadEstrellas LIKE $valoracion
                                        AND precio BETWEEN TRUNCATE( $min,0) AND TRUNCATE($max,0)";
                                
                            } if($min==0 && $max==0 ){//si campos de rangos iguales a cero no los toma en el where
                                $where="where c.idcategoria like $fcategoria
                                        AND m.idMunicipios like $flugar 
                                        AND cv.cantidadEstrellas LIKE $valoracion";

                            }
                                               
                    }
                                        
                }if($valoracion=="" || $valoracion==NULL){//si valoracion vacio; lugar lleno, cateogira llena , demas llenos 
                    if (isset($_GET["minimo"]) && isset($_GET["maximo"])){
                        $min=$_GET["minimo"];
                        $max=$_GET["maximo"];
                        
                               
                            if ($min==0 && $max>0 ){ //si campo de rango max es mayor a cero
                                
                                    $where="where c.idcategoria like $fcategoria
                                        AND m.idMunicipios like $flugar 
                                        AND precio BETWEEN TRUNCATE( $min,0) AND TRUNCATE($max,0)";
                                
                            }if($min==0 && $max==0 ){//si campos de rangos iguales a cero no los toma en el where
                                $where="where c.idcategoria like $fcategoria
                                        AND m.idMunicipios like $flugar";

                            }
                                               
                    }
                    
                } 
                
            } if($fcategoria=="" || $fcategoria==NULL){//si categoria vaciaa ; lugar valoracion min max no
                if (isset($_GET["valoracion"])){
                    $valoracion=$_GET["valoracion"];

                    if (isset($_GET["minimo"]) && isset($_GET["maximo"])){
                        $min=$_GET["minimo"];
                        $max=$_GET["maximo"];
                        
                               
                            if ($min==0 && $max>0 ){ //si campo de rango max es mayor a cero
                                
                                    $where="where m.idMunicipios like $flugar 
                                        AND cv.cantidadEstrellas LIKE $valoracion
                                        AND precio BETWEEN TRUNCATE( $min,0) AND TRUNCATE($max,0)";
                                
                            } if($min==0 && $max==0 ){//si campos de rangos iguales a cero no los toma en el where
                                $where="where m.idMunicipios like $flugar 
                                        AND cv.cantidadEstrellas LIKE $valoracion";

                            }
                                               
                    }

                                        
                } if($valoracion=="" || $valoracion==NULL){//si valoracion vacio; lugar lleno, cateogira vacia , demas llenos 
                   
                    if (isset($_GET["minimo"]) && isset($_GET["maximo"])){
                        $min=$_GET["minimo"];
                        $max=$_GET["maximo"];
                        
                               
                            if ($min==0 && $max>0 ){ //si campo de rango max es mayor a cero
                                
                                    $where="where  m.idMunicipios like $flugar 
                                        AND precio BETWEEN TRUNCATE( $min,0) AND TRUNCATE($max,0)";
                                
                            } if($min==0 && $max==0 ){//si campos de rangos iguales a cero no los toma en el where
                                $where="where  m.idMunicipios like $flugar ";

                            }
                                               
                    }
                   
                } 

            }
            
        }

        if($flugar=="" || $flugar==NULL){ //si lugar vacio demás datos llenos

            if (isset($_GET["fcategoria"])){
                $fcategoria=$_GET["fcategoria"];

                if (isset($_GET["valoracion"])){
                    $valoracion=$_GET["valoracion"];

                    if (isset($_GET["minimo"]) && isset($_GET["maximo"])){
                        $min=$_GET["minimo"];
                        $max=$_GET["maximo"];
                        
                               
                            if ($min==0 && $max>0 ){ //si campo de rango max es mayor a cero
                                
                                    $where="where c.idcategoria like $fcategoria
                                        AND cv.cantidadEstrellas LIKE $valoracion
                                        AND precio BETWEEN TRUNCATE( $min,0) AND TRUNCATE($max,0)";
                                
                            } if($min==0 && $max==0 ){//si campos de rangos iguales a cero no los toma en el where
                                $where="where c.idcategoria like $fcategoria
                                        AND cv.cantidadEstrellas LIKE $valoracion";

                            }
                                               
                    }

                    
                                        
                } if($valoracion=="" || $valoracion==NULL){//si lugar vacio, cateogira llena valoracion vacio, demas llenos 
                    
                    if (isset($_GET["minimo"]) && isset($_GET["maximo"])){
                        $min=$_GET["minimo"];
                        $max=$_GET["maximo"];
                        
                               
                            if ($min==0 && $max>0 ){ //si campo de rango max es mayor a cero
                                
                                    $where="where c.idcategoria like $fcategoria
                                        AND precio BETWEEN TRUNCATE( $min,0) AND TRUNCATE($max,0)";
                                
                            } if($min==0 && $max==0 ){//si campos de rangos iguales a cero no los toma en el where
                                $where="where c.idcategoria like $fcategoria ";

                            }
                                               
                    }
                    
                }
                
            }if($fcategoria=="" || $fcategoria==NULL){//si categoria lugar vacia ; valoracion min max no
                if (isset($_GET["valoracion"])){
                    $valoracion=$_GET["valoracion"];

                    if (isset($_GET["minimo"]) && isset($_GET["maximo"])){
                        $min=$_GET["minimo"];
                        $max=$_GET["maximo"];
                        
                               
                            if ($min==0 && $max>0 ){ //si campo de rango max es mayor a cero
                                
                                    $where="where cv.cantidadEstrellas LIKE $valoracion
                                        AND precio BETWEEN TRUNCATE( $min,0) AND TRUNCATE($max,0)";
                                
                            } if($min==0 && $max==0 ){//si campos de rangos iguales a cero no los toma en el where
                                $where="where  cv.cantidadEstrellas LIKE $valoracion";

                            }
                                               
                    }

                                        
                } if($valoracion=="" || $valoracion==NULL){//si lugar cateogira valoracion vacio, demas llenos 
                    
                    if (isset($_GET["minimo"]) && isset($_GET["maximo"])){
                        $min=$_GET["minimo"];
                        $max=$_GET["maximo"];
                        
                               
                            if ($min==0 && $max>0 ){ //si campo de rango max es mayor a cero
                                
                                    $where="where precio BETWEEN TRUNCATE( $min,0) AND TRUNCATE($max,0)";
                                
                            } if($min==0 && $max==0 ){//si campos de rangos iguales a cero no los toma en el where
                                $where=" ";

                            }
                                               
                    }
                    
                }

            }
            
        }
        
    
        $conexion = new conexion();
        $sql="SELECT idAnuncios,nombre,precio,descripcion FROM anuncios a 
        INNER JOIN municipios m ON m.idMunicipios= a.idMunicipios 
        INNER JOIN categoria c ON c.idcategoria=a.idcategoria 
        INNER JOIN usuario u on u.idUsuario=a.idUsuario 
        INNER JOIN calificacionesvendedor cv ON cv.idUsuario=u.idUsuario
        $where
        ORDER BY idAnuncios DESC;";//CONSULTA 
        
        if($resultado=$conexion->ejecutarInstruccion($sql)){
            if($resultado->num_rows!=0){
                $datos=array();
                
                
                $i=0;
                while($row=$resultado->fetch_array()){

                    $datos[]=array("idAnuncios"=>$row["idAnuncios"],"nombre"=>$row["nombre"],
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
                $mensaje=array();
                $mensaje[]=array("mensaje"=>'No se encontraron coincidencias');
                echo json_encode($mensaje);
            }
        }
        else{
            echo json_encode(array("error"=>true,"mensaje"=>"fallo en la consulta"));
        }
        $conexion->cerrarConexion();

    break;
}


?>