<?php
    require_once("conexion.php");

    switch ($_GET["accion"]) {                                                                                      //Inicio de switch
        case '1':                                                                                                   //Actualizar datos
            if(isset($_POST["txt_nombre"])){                                                                            //Comienza a asignar las variables POST
                $nombre = $_POST["txt_nombre"];
            }
            if(isset($_POST["txt_apellido"])){
                $apellido = $_POST["txt_apellido"];
            }
            if(isset($_POST["txt_correo"])){
                $correo = $_POST["txt_correo"];
            }
            if(isset($_POST["date_fecha"])){
                $fecha = $_POST["date_fecha"];
            }
            if(isset($_POST["int_municipio"])){
                $idMunicipio = $_POST["int_municipio"];
            }
            if(isset($_POST["txt_tefelono"])){
                $telefono = $_POST["txt_tefelono"];
            }
            if($nombre=="" || $nombre==NULL){                                                                       //Comienza a vericar que no sean valores nulos o vacios
                $respuesta="Ingrese el nombre";
                echo $respuesta;
            }
            if($apellido=="" || $apellido==NULL){
                $respuesta="Ingrese el apellido";
                echo $respuesta;
            }
            if($correo=="" || $correo==NULL){
                $respuesta="Ingrese el correo";
                echo $respuesta;
            }
            if($fecha=="" || $fecha==NULL){
                $respuesta="Ingrese la fecha";
                echo $respuesta;
            }
            if($idMunicipio=="" || $idMunicipio==NULL){
                $respuesta="Ingrese el municipio";
                echo $respuesta;
            }
            if($telefono=="" || $telefono==NULL){
                $respuesta="Ingrese el telefono";
                echo $respuesta;
            }                                                                                                        //Fin de validación
            else{
                $date = str_replace('/', '-', $fecha);                                                                //Sustituimos caracterés / por -
                $fecha = date('Y-m-d', strtotime($date));   
                $conexion = new conexion();

                $sql="";
                
  
            }                                           
        break;
    }