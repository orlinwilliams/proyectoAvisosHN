<?php

	class Conexion{

		private $usuario="root";
		private $contrasena="";
		private $host="localhost";
		private $baseDatos="avisoshn";
		private $puerto="3308";
		private $link;

		public function __construct(){
			$this->establecerConexion();			
		}

		public function establecerConexion(){
			$this->link = mysqli_connect($this->host, $this->usuario, $this->contrasena, $this->baseDatos, $this->puerto);

			if (!$this->link){
				echo "No se pudo conectar con mysql";
				exit;
			}
		}
		
		public function cerrarConexion(){
			mysqli_close($this->link);
		}
		public function ejecutarInstruccion($sql){
			return mysqli_query($this->link, $sql);
		}

		public function ejecutarMultipleInstruccion($sql){
			return mysqli_multi_query($this->link, $sql);
		}

		public function obtenerFila($sql){
			return mysqli_fetch_array($sql);
		}
		public function error(){
			return mysqli_error($this->link);
		}
		public function masResultados(){
			return mysqli_more_results($this->link);
		}
		public function errno(){
			return mysqli_errno($this->link);
		}
		public function siguienteResultado(){
			return mysqli_next_result($this->link);
		}
		public function liberarResultado($sql){
			mysqli_free_result($sql);
		}

		public function getUsuario(){
			return $this->usuario;
		}

		public function setUsuario($usuario){
			$this->usuario = $usuario;
		}

		public function getContrasena(){
			return $this->contrasena;
		}

		public function setContrasena($contrasena){
			$this->contrasena = $contrasena;
		}

		public function getHost(){
			return $this->host;
		}

		public function setHost($host){
			$this->host = $host;
		}

		public function getBaseDatos(){
			return $this->baseDatos;
		}

		public function setBaseDatos($baseDatos){
			$this->baseDatos = $baseDatos;
		}

		public function getPuerto(){
			return $this->puerto;
		}

		public function setPuerto($puerto){
			$this->puerto = $puerto;
		}

		public function getLink(){
			return $this->link;
		}
		
		public function setLink($link){
			$this->link = $link;
		}

	}
?>