
<?php	
	include_once("conexion.php");
	$conexion = new Conexion();	

    $resultado = $conexion->ejecutarInstruccion('SELECT iddepartamentos, nombredepartamento FROM departamentos');
	echo '<table border="1px">';
        while($fila = $conexion->obtenerFila($resultado)){
            echo "<tr>";
            echo "<td>". $fila["iddepartamentos"]. "</td>"; 
            echo "<td>". $fila["nombredepartamento"]. "</td>";      
            echo "</tr>";
        }
    echo "</table>";

	$conexion->cerrarConexion();
?>