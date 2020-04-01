<?php

  if ($peticionAjax){
    	require_once '../core/configAPP.php';
    } else{
    	require_once './core/configAPP.php';
    }

  class mainModel{
    
    protected function conectar(){
			$enlace = new PDO(SGBD, USER, PASS);
			return $enlace;    	
    }

    protected function ejecutar_consulta_simple($consulta){
    	$respuesta = self::conectar()->prepare($consulta);
    	$respuesta -> execute();
    	return $respuesta;
    }

    protected function agregar_cuenta($datos){
    	$sql=self::conectar->prepare("INSERT INTO cuenta(CuentaCodigo, CuentaPrivilegio, CuentaUsuario, CunetaClave, CuentaEmail, CuentaEstado, CuentaTipo, CuentaGenero, CuentaFoto) VALUES(:Codigo, :Privilegio, :Usuario, :Clave, :Email, :Estado, :Tipo, :Genero, :Foto)");
    	$sql->bindParam(":Codigo", $datos['Codigo']);
    	$sql->bindParam(":Privilegio", $datos['Privilegio']);
    	$sql->bindParam(":Usuario", $datos['Usuario']);
    	$sql->bindParam(":Clave", $datos['Clave']);
    	$sql->bindParam(":Email", $datos['Email']);
    	$sql->bindParam(":Estado", $datos['Estado']);
    	$sql->bindParam(":Tipo", $datos['Tipo']);
    	$sql->bindParam(":Genero", $datos['Genero']);
    	$sql->bindParam(":Foto", $datos['Foto']);
    }

    // Funciones para encriptar contraseñas
    public static function encryption($string){
			$output=FALSE;
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_encrypt($string, METHOD, $key, 0, $iv);
			$output=base64_encode($output);
			return $output;
		}
		public static function decryption($string){
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
			return $output;
		}

		// Funcion para generar text aleatorio para sumarle al uri
		protected function generar_codigo_aleatorio($letra, $longitud, $num){
			for($i=1; $i<=$longitud; $i++){
				$numero = rand(0,9);
				$letra.= $numero;
			}
			return $letra.$num;
		}

		// Limpiar texto de formularios
		protected function limpiar_cadena($cadena){
			$cadena=trim($cadena);
			$cadena=stripslashes($cadena);
			$cadena=str_ireplace("<script>", "", $cadena);			
			$cadena=str_ireplace("</script>", "", $cadena);			
			$cadena=str_ireplace("<script src>", "", $cadena);			
			$cadena=str_ireplace("SELECT * FROM", "", $cadena);
			$cadena=str_ireplace("DELETE FROM", "", $cadena);			
			$cadena=str_ireplace("INSERT INTO", "", $cadena);			
			$cadena=str_ireplace("--", "", $cadena);			
			$cadena=str_ireplace("^", "", $cadena);			
			$cadena=str_ireplace("[", "", $cadena);			
			$cadena=str_ireplace("]", "", $cadena);			
			$cadena=str_ireplace("==", "", $cadena);
			$cadena=str_ireplace(";", "", $cadena);
			return $cadena;
		}

		// Maneja mensajes de sistemas
		protected function sweet_alert($datos){
			if ($datos['Alerta']=="simple"){
							$alerta="
								<script>
									swal(
									  title: '".$datos.['Titulo']"',
									  text: '".$datos.['Texto']"',
									  '".$datos.['Tipo']"',
									);
									</script>

							";
			}elseif ($datos.['Alerta']=='recargar'){
							$alerta="
								<script>
									Swal({
									  title: '".$datos.['Titulo']"',
									  text: '".$datos.['Text']"',
									  type: '".$datos.['Tipo']",
									  confirmButtonText: 'Aceptar'
									}).then(function (){
										location.reload();
										}

									});
									</script>

							";
			}elseif($datos.['Alerta']=='limpiar'){
							$alerta="
								<script>
									Swal({
									  title: '".$datos.['Titulo']"',
									  text: '".$datos.['Text']"',
									  type: '".$datos.['Tipo']",
									  confirmButtonText: 'Aceptar'
									}).then(function (){
											$('.FormularioAjax')[0].reset();
										}
									});
									</script>

							";
			}
			return $alerta;

		}

  }
  