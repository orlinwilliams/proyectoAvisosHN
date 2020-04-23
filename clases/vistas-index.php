<?php
    require_once("conexion.php");
    require_once("correo.php");
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
            $conexion = new conexion();
            $sql = "SELECT iddepartamentos, nombredepartamento FROM `departamentos`
                ORDER by iddepartamentos ASC;";
            $resultado = $conexion->ejecutarInstruccion($sql);
            if (!$resultado) {
                echo "No hay municipios";
            } else {
                while ($fila = $conexion->obtenerFila($resultado)) {                                                    //Recorre todas las filas de departamentos
                    $iddepartamento = $fila["iddepartamentos"];
                    echo '<optgroup label="' . $fila["nombredepartamento"] . '">';
    
                    $sql2 = "SELECT idmunicipios, municipio FROM `municipios`
                        WHERE iddepartamentos=$iddepartamento
                        ORDER by idmunicipios ASC;";                                                                    //Por cada departamento consultará los municipios que pertenecen al departamento
    
                    $resultado2 = $conexion->ejecutarInstruccion($sql2);
                    if ($resultado2) {
                        while ($fila2 = $conexion->obtenerFila($resultado2)) {                                          //Recorre todas las filas de municipio según el departamento
                            echo '<option value="' . $fila2["idmunicipios"] . '">' . $fila2["municipio"] . '</option>';
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
                                m.municipio, cv.cantidadEstrellas,u.correoElectronico, u.numTelefono, u.fechaRegistro, u.urlFoto FROM anuncios a
                                INNER JOIN categoria c ON c.idcategoria=a.idcategoria
                                INNER JOIN grupoCategoria g ON g.idgrupocategoria=c.idgrupocategoria
                                INNER JOIN usuario u ON u.idUsuario=a.idUsuario
                                INNER JOIN municipios m ON m.idmunicipios=a.idmunicipios
                                LEFT JOIN calificacionesvendedor cv ON cv.idUsuario=a.idUsuario
                                WHERE a.idAnuncios = $idAnuncio;";
                $respuesta=$conexion->ejecutarInstruccion($sql);
                if(!$respuesta){
                    echo "Oops, ha ocurrido un error";
                }
                else{
                    $datos = $conexion->obtenerFila($respuesta);
                    $fila["info"]=array("idAnuncios"=>$datos["idAnuncios"],"nombre"=>$datos["nombre"],"precio"=>$datos["precio"],
                        "descripcion"=>$datos["descripcion"],"estadoArticulo"=>$datos["estadoArticulo"],"nombreCategoria"=>$datos["nombreCategoria"],
                        "nombregrupo"=>$datos["nombregrupo"],"idUsuario"=>$datos["idUsuario"],"correoElectronico"=>$datos["correoElectronico"],"nombreUsuario"=>$datos["nombreUsuario"],
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
                
                $conexion->cerrarConexion();                
            }
        break;
        case '5':
            if (isset($_GET["idUsuario"])){
                $idUsuario=$_GET["idUsuario"];
            }
            if($idUsuario == "" | $idUsuario == NULL){
                echo "idUsuario no ingresado";
            }
            else{
                $conexion = new conexion();
                $sql = "SELECT U.idUsuario, U.pNombre,U.pApellido,U.urlFoto, U.correoElectronico,U.fechaRegistro, T.tipoUsuario, CV.cantidadEstrellas, CV.comentarios,(SELECT COUNT(idUsuario) FROM anuncios WHERE idUsuario='$idUsuario') as cantidadAnuncio FROM usuario as U
                INNER JOIN tipoUsuario as T
                ON T.idTipoUsuario=U.idTipoUsuario
                LEFT JOIN calificacionesvendedor as CV
                ON U.idUsuario=CV.idUsuario
                WHERE U.idUsuario='$idUsuario';";
                
                $respuesta=$conexion->ejecutarInstruccion($sql);
                if(!$respuesta){
                    echo "Error en consulta vendedor";
                }
                else{
                    $datos = $conexion->obtenerFila($respuesta);
                    
                    echo json_encode(array("idUsuario"=>$datos["idUsuario"],"pNombre"=>$datos["pNombre"],"pApellido"=>$datos["pApellido"],"urlFoto"=>$datos["urlFoto"],
                    "correoElectronico"=>$datos["correoElectronico"],"fechaRegistro"=>$datos["fechaRegistro"],"tipoUsuario"=>$datos["tipoUsuario"],"cantidadEstrellas"=>$datos["cantidadEstrellas"],
                    "comentarios"=>$datos["comentarios"],"cantidadAnuncio"=>$datos["cantidadAnuncio"]
                ));
                    
                    
                }
                
                
            }
            $conexion->cerrarConexion();
        break;
        case '6':///Datos para hacer contacto con vendedor
            $conexion = new Conexion();
            session_start();
            $idUsuario=$_SESSION["usuario"]["idUsuario"];
            $pNombre=$_SESSION["usuario"]["pNombre"];
            $pApellido=$_SESSION["usuario"]["pApellido"];
            if (isset($_POST["idAnuncio2"])){
             $idAnuncio=$_POST["idAnuncio2"];
             }
             $sql = "SELECT nombre FROM anuncios a
             WHERE a.idAnuncios= '$idAnuncio'";
             $salida = "SELECT @p10 AS `mensaje`;";                                                                //Llamado al parametro de salida del procedimiento almacenado
             $resultado = $conexion->ejecutarInstruccion($sql);
             $respuesta = $conexion->ejecutarInstruccion($salida);
             $fila5=$conexion->obtenerFila($resultado);
             $nombreAnun=$fila5["nombre"];
             echo $nombreAnun;
             $conexion->cerrarConexion();
         break;
         case '7':///se envia correo para hacer contacto con vendedor
             $conexion = new Conexion();
             session_start();
             $idUsuario=$_SESSION["usuario"]["idUsuario"];
             $pNombre=$_SESSION["usuario"]["pNombre"];
             $pApellido=$_SESSION["usuario"]["pApellido"];
             $correoCliente=$_SESSION["usuario"]["correoElectronico"];
             if (isset($_POST["idanuncio3"])){
              $idAnuncio=$_POST["idanuncio3"];
              }
             if (isset($_POST["mensaje1"])){
                 $mensaje1=$_POST["mensaje1"];
                 }
             if($mensaje1=="" || $mensaje1==NULL){
                     $respuesta="Ingrese su mensaje a enviar.";
                     echo $respuesta;
             }
              $sql = "SELECT nombre, u.correoElectronico, concat_ws(' ',u.pnombre, u.papellido) as nombreVendedor FROM anuncios a 
              INNER JOIN usuario u on u.idUsuario=a.idUsuario WHERE a.idAnuncios= '$idAnuncio'";
              $salida = "SELECT @p10 AS `mensaje`;";                                                                //Llamado al parametro de salida del procedimiento almacenado
              $resultado = $conexion->ejecutarInstruccion($sql);
              $respuesta = $conexion->ejecutarInstruccion($salida);
              $fila5=$conexion->obtenerFila($resultado);
              $fila4=$conexion->obtenerFila($respuesta);
              $correoVendedor=$fila5["correoElectronico"];
              $nombreVendedor=$fila5["nombreVendedor"];
                      $nombreServer=$_SERVER['SERVER_NAME'];
                      $mensajeEncabezado="<br>Somos MARKETHN<br><br>";
                      $mensaje=$mensajeEncabezado."El usuario: ".$pNombre." ".$pApellido." con correo: ".$correoCliente." dice:<br>".$mensaje1." <br> ";
                      $correo= new Correo($correoVendedor,$nombreVendedor,"Cliente interesado",$mensaje);
                          if($correo->enviarCorreo()){//SE ENVIA CORREO
                              echo $fila4["mensaje"]."Correo enviado";
                          }
                          else{
                              echo "FALLO EN ENVIO DE CORREO";
                          }
              $conexion->cerrarConexion();
          break;
     
        }

?>