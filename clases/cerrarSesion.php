<?php
    session_start();                        //Inicia sessions

    session_destroy();                      //Destruye la sesión y su contenido

    header('Location:../index.php')      //Redirige al index
?>