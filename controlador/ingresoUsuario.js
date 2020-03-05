$("form").submit(function(event){
    //alert("NO ENTRA AL SUBMIT");
    event.preventDefault();
    //alert();
    //console.log($("form").serialize());
   
    $.ajax({

        beforeSend:function(){
            $("#envioFormularioLogin").html("ENVIANDO..");
            //$("#btnAddProfile").html('Save');

        },
        url:"http://localhost/proyectoAvisosHN/clases/ingresoUsuario.php",
        data:$("form").serialize(),
        type:"POST",
        success:function(resp){
            if(resp=="1"){
                location.href="http://localhost/proyectoAvisosHN/vistas/perfil.php"
                //alert("USUARIO REGISTRADO");
            }
            else if(resp=="2"){
                alert("revise su correo o password");
                //location.href="http://localhost/proyectoAvisosHN/vistas/registro.php"
            }
        },
        error:function(error){
            console.log(error);
            alert(error)
            

        },
        complete:function(status){//se ejecuta despues de error o success
            console.log(status);
            $("#envioFormularioLogin").html("Ingresar");


        },
        
    });
});
