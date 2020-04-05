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
            
            if(isset($_POST[$fotos])){
                $imagenArchivo=$_FILES["fotos"]["tmp_name"];
                $nombreImagen=$_FILES["fotos"]["name"];
            }
            /*
            if (isset($_FILES["foto"])) {
                $reporte = null;
                for ($$x=0; $$x < count($_FILES["foto"]["name"]); $$x++) { 
                
                $file = $_FILES["foto"];
                $nombreImagen = $file["name"][$x];
                $tipo = $file["type"][$x];
                $ruta_provisional = $file["tmp_name"][$x];
                $size = $file["size"][$x];
                $dimensiones = getimagesize($ruta_provisional);
                $width = $dimensiones[0];
                $heigth = $dimensiones[1];
                $carpeta = "../foto_anuncio/";
            
                if ($tipo != 'image/jpeg' && $tipo != 'image/jpeg' && $tipo != 'image/png' && $tipo != 'image/gif') {
                    $reporte .= "<p style='color: red'>Error $nombre, el archivo no es una imagen</p";
                }
                else if($size > 1024*1024)
                {
                    $reporte .= "<p style='color: red'>Error $nombre, el tamaño maximo es  1MB</p";
                }
                else if($width > 500 || $heigth > 500)
                {
                    $reporte .= "<p style='color: red'>Error $nombre, la altura y anchura max es de 500px</p";
                }
                else if($width < 60 || $heigth < 60)
                {
                    $reporte .= "<p style='color: red'>Error $nombre, la altura y anchura min es de 60</p";
                }
                else {
                     $src = $carpeta.$nombreImagen;
                     move_uploaded_file($ruta_provisional, $src);
                     echo "<p style='color: blue'>Error $nombreImagen, ha sido subida con exito</p";
                }
            }
                echo $reporte;  
        }    
        */  
        //Fin de validación
            else{
                session_start();
                $idUsuario=$_SESSION["usuario"]["idUsuario"];
                $idMunicipio=$_SESSION["usuario"]["idMunicipios"];
                //$idAnuncio=$_SESSION["usuario"]["idUsuario"];
         /*   orlin    
                //pasar al if
                $carpeta="foto_anuncio/";
                $ruta1="../images/".$carpeta.$nombreImagen;
                move_uploaded_file($imagenArchivo,$ruta1);
                $imagenArchivo[0];
                $conexion = new Conexion();
         */       
                //ESTRUCTURA PROCEDIMIENTO
                //SET @p0='2'; SET @p1='3'; SET @p2='5'; SET @p3='prueba1'; SET @p4='9999'; SET @p5='nuevo'; SET @p6='qwerty';
                //CALL `SP_PUBLICAR_ANUNCIO`(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7);
                //SELECT @p7 AS `pcMensaje`;

                $sql = "CALL `SP_PUBLICAR_ANUNCIO`('$idUsuario','$idCategoria','$idMunicipio','$nombre','$precio','$estado','$descripcion',@p7);";
                //$sql = "INSERT INTO 'fotos' (NOMBRE) VALUES($nombre) ";
               // $salida = "INSERT INTO 'ANUNCIOS' (ESTADO) VALUES ($estado)"; 
                $salida = "SELECT @p7 AS `pcMensaje`;";  

                ///
                $sql2="INSERT INTO fotos (idAnuncios,localizacion) values ('$idAnuncio','$ruta1')";
                                                                 //Llamado al parametro de salida del procedimiento almacenado
                $resultado = $conexion->ejecutarInstruccion($sql);
                $respuesta = $conexion->ejecutarInstruccion($salida);
                $resultado2 = $conexion->ejecutarInstruccion($sql2);
                   if(!$resultado){
                    echo "No hay respuesta del procedimiento"; 
                   }
                   else{
                        $fila=$conexion->obtenerFila($respuesta);
                        //consulta para idAnuncio if
                        $idAnuncio="SELECT MAX(idAnuncios) FROM anuncios";
                        
                        if(!$resultado2){
                            echo "error al guardar la imagen"; 
                           }
                           
                           else{
                                echo "la imagen se guardo corretamnete";      
                           }

                        echo $fila["pcMensaje"];       
                   }

                    $conexion->cerrarConexion();
                }
            break;
         
    }

?>