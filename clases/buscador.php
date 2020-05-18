<?php
    require_once("conexion.php");

    switch($_GET['accion']){ //BUSCADOR EN TIEMPO REAL
        case '1':
            if(!isset($_POST["value"])){
                echo json_encode(array("error"=>true,"mensaje"=>"no hay palabra clave"));
            }
            else{
                $conexion = new conexion();
                $palabraClave=$_POST["value"];
                
                $sql="SELECT A.idAnuncios,A.nombre,A.precio,A.descripcion,c.nombreCategoria,g.nombregrupo 
                    FROM anuncios A 
                    INNER JOIN categoria c ON c.idcategoria=a.idcategoria
                    INNER JOIN grupoCategoria g ON g.idgrupocategoria=c.idgrupocategoria
                    WHERE A.nombre like '%$palabraClave%' OR c.nombreCategoria like '%$palabraClave%' OR g.nombregrupo like '%$palabraClave%'
                    ORDER BY idAnuncios DESC";

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
                        echo json_encode(array("error"=>true,"mensaje"=>"No hay anuncios"));
                    }
                }
                else{
                    echo json_encode(array("error"=>true,"mensaje"=>"fallo en la consulta"));
                }
                $conexion->cerrarConexion();
    
            }
        break;

        case '2':
            if(!isset($_POST["value"])){
                echo json_encode(array("error"=>true,"mensaje"=>"no hay palabra clave"));
            }
            elseif($_POST["value"]==""){
                echo json_encode(array("error"=>true,"mensaje"=>"no hay palabra clave"));
            }
            elseif($_POST["value"]==" "){
                echo json_encode(array("error"=>true,"mensaje"=>"no hay palabra clave"));
            }

            else{
                $conexion = new conexion();
                $palabraClave=$_POST["value"];
                session_start();
                $idUsuario=$_SESSION["usuario"]["idUsuario"];
                
                $sql="SELECT A.idUsuario, A.idAnuncios,A.nombre,A.precio,A.descripcion,c.nombreCategoria,g.nombregrupo 
                    FROM anuncios A 
                    INNER JOIN categoria c ON c.idcategoria=a.idcategoria
                    INNER JOIN grupoCategoria g ON g.idgrupocategoria=c.idgrupocategoria
                    WHERE A.idUsuario='$idUsuario' AND (A.nombre like '%$palabraClave%' OR c.nombreCategoria like '%$palabraClave%' OR g.nombregrupo like '%$palabraClave%')
                    ORDER BY idAnuncios DESC";

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
                        echo json_encode(array("error"=>true,"mensaje"=>"No hay anuncios"));
                    }
                }
                else{
                    echo json_encode(array("error"=>true,"mensaje"=>"fallo en la consulta"));
                }
                $conexion->cerrarConexion();
    
            }
        break;


    }
?>