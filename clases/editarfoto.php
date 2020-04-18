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
           
                   
                    
                     
                     $sql="SELECT localizacion FROM fotos WHERE idAnuncios='$idanuncios'";
                        if($resultado=$conexion->ejecutarInstruccion($sql)){
                            if($resultado->num_rows!=0){
                              
                                $fotos=array();
                                while($row=$resultado->fetch_array()){   
                                    $fotos[]=$row["localizacion"];
                               
                                }
                                
                             
                                //echo var_dump($datosFotos) ;
                            
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
                        
                                
                    
                    
                    echo json_encode($fotos) ; 
           
            $conexion->cerrarConexion();

        break;


    }


    ?>