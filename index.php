<%-- 
    Document   : index
    Created on : 1 mar. 2020, 14:03:12
    Author     : kmell
--%>

<%@page contentType="text/html" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title>Cargando...</title>

    </head>

    <body>
        <script>
            // self executing function here
            (function () {
                // your page initialization code here
                // the DOM will be available here
                alert("Redireccionando...");
                location.href = "vistas/login.php";
            })();
        </script>
    </body>

</html>
