<?php
    require_once("conexion.php");
    switch ($_GET["accion"]){
        case '1':                                                                                                   //Obtiene las categorias
            $conexion = new conexion();
            $sql="SELECT idgrupocategoria, nombregrupo FROM `grupocategoria`
            ORDER by idgrupocategoria ASC;";
            $resultado=$conexion->ejecutarInstruccion($sql);
            if(!$resultado){
                echo "No hay categorias";
            }
            else{
                while($fila=$conexion->obtenerFila($resultado)){                                                    //Recorre todas las filas de grupo de categoria
                    $idgrupocategoria=$fila["idgrupocategoria"];
                    echo '<optgroup label="'.$fila["nombregrupo"].'">';

                    $sql2="SELECT idcategoria, nombrecategoria FROM `categoria`
                    WHERE idgrupocategoria=$idgrupocategoria
                    ORDER by idcategoria ASC;";                                                                    //Por cada grupo consultará los categorias que pertenecen al grupo

                    $resultado2=$conexion->ejecutarInstruccion($sql2);
                    if($resultado2){
                        while($fila2=$conexion->obtenerFila($resultado2)){                                          //Recorre todas las filas de categorias según el grupo
                            echo'<option value="'.$fila2["idcategoria"].'">'.$fila2["nombrecategoria"].'</option>';
                        }
                    }
                    echo '</optgroup>';
                }
            }
            $conexion->cerrarConexion();
        break;
         
        case '3':       //PUBLICACIONES INICIOUSUARIO
            $conexion = new conexion();
            $sql="SELECT idAnuncios,nombre,precio,descripcion 
                    FROM anuncios ORDER BY idAnuncios DESC";//CONSULTA PUBLICACIONES INICIO
            if($resultado=$conexion->ejecutarInstruccion($sql)){
                if($resultado->num_rows!=0){
                    $datos=array();
                    
                    //$idAnuncio=$datos["idAnuncios"];
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
                    echo json_encode(array("error"=>true,"mensaje"=>"No hay anuncios"));
                }
            }
            else{
                echo json_encode(array("error"=>true,"mensaje"=>"fallo en la consulta"));
            }
            $conexion->cerrarConexion();

        break;
            
        case '4':
            if (isset($_GET["idAnuncio"])){
                $idAnuncio=$_GET["idAnuncio"];
            }
            if($idAnuncio == "" | $idAnuncio == NULL){
                echo "idAnuncio no ingresado";
            }
            else{
                $conexion = new conexion();
                $sql = "SELECT idAnuncios, nombre, precio, descripcion, estadoArticulo, c.nombreCategoria,
                                g.nombregrupo, u.idUsuario, concat_ws(' ',u.pnombre, u.papellido) as nombreUsuario,
                                m.municipio, cv.cantidadEstrellas, u.numTelefono, u.fechaRegistro, u.urlFoto FROM anuncios a
                                INNER JOIN categoria c ON c.idcategoria=a.idcategoria
                                INNER JOIN grupoCategoria g ON g.idgrupocategoria=c.idgrupocategoria
                                INNER JOIN usuario u ON u.idUsuario=a.idUsuario
                                INNER JOIN municipios m ON m.idmunicipios=a.idmunicipios
                                INNER JOIN calificacionesvendedor cv ON cv.idUsuario=a.idUsuario
                                WHERE a.idAnuncios = $idAnuncio;";
                $respuesta=$conexion->ejecutarInstruccion($sql);
                if(!$respuesta){
                    echo "Oops, ha ocurrido un error";
                }
                else{
                    $datos = $conexion->obtenerFila($respuesta);
                    $fila["info"]=array("idAnuncios"=>$datos["idAnuncios"],"nombre"=>$datos["nombre"],"precio"=>$datos["precio"],
                        "descripcion"=>$datos["descripcion"],"estadoArticulo"=>$datos["estadoArticulo"],"nombreCategoria"=>$datos["nombreCategoria"],
                        "nombregrupo"=>$datos["nombregrupo"],"idUsuario"=>$datos["idUsuario"],"nombreUsuario"=>$datos["nombreUsuario"],
                        "municipio"=>$datos["municipio"],"cantidadEstrellas"=>$datos["cantidadEstrellas"],"numTelefono"=>$datos["numTelefono"],
                        "fechaRegistro"=>$datos["fechaRegistro"],"urlFoto"=>$datos["urlFoto"],"fotos"=>"");
                    $sql = "SELECT localizacion FROM fotos
                            WHERE idAnuncios=$idAnuncio;";
                    $respuesta=$conexion->ejecutarInstruccion($sql);
                    if(!$respuesta){
                        echo "No se encontraron fotos";
                    }
                    else{
                        while($row = $conexion->obtenerFila($respuesta)){
                            $fotos[]=$row["localizacion"];
                        }
                        $fila["info"]["fotos"]=$fotos;
                    }
                    echo json_encode($fila);
                }
                
                
            }
        break;
     
        }

?>