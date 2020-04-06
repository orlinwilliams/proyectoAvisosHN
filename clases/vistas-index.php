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

        case '2':
                                                                                                               //Registrar usuario
            if(isset($_POST["categoria"])){                                                                            //Comienza a asignar las variables POST
                $idCategoria = $_POST["categoria"];
            }
            if(isset($_POST["nombre"])){                                                                            //Comienza a asignar las variables POST
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
            }                                                                                                     //Fin de la asignación
            /////////////////////////////////////////////////////////////
            if($nombre=="" || $nombre==NULL){                                                                       //Comienza a vericar que no sean valores nulos o vacios
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

            
            if(!isset($_FILES["fotos"])){
                echo "Debe subir minimo una imagen";
            }
            //$conexion = new conexion();
            $imagenArchivo=$_FILES["fotos"]["tmp_name"];
            $nombreImagen=$_FILES["fotos"]["name"];
            
            echo "# de fotos:".count($_FILES["fotos"]["name"]);
           
            /*session_start();
            $idUsuario=$_SESSION["usuario"]["idUsuario"];
            $idMunicipio=$_SESSION["usuario"]["idMunicipios"];
            $usuario=$_SESSION["usuario"]["correoElectronico"];
            
            $carpetaFoto="fotosAnuncio/";
            
            //$ruta="../images/".$carpeta.$nombreImagen;
            //move_uploaded_file($imagenArchivo,$ruta);
            
           

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
                        $ruta[$i]="../images/".$carpetaFoto.$carpetaUsuario.$nombreImagen[$i];
                        move_uploaded_file($imagenArchivo[$i],$ruta[$i]);
                        $sqlArray[$i]="INSERT INTO fotos (idAnuncios,localizacion) values ('$lastId','$ruta[$i]')";
                        if($conexion->ejecutarInstruccion($sqlArray[$i])){
                            $mensajeValidacion=[$i];
                        }
                        else{
                            echo " Erro en foto: ".$nombreImagen[$i];
                        }
                        if($mensajeValidacion==count($nombreImagen)){
                            echo "Anuncio agregado correctamente";
                        }
                    }        
                    
                    

                }
                else{
                    echo" no se obtuvo el ultimo id";
                }
                
            }
            else{
                echo "Error en el procediimiento almacenado";
            }*/

                
                
            break;
         
    }

?>