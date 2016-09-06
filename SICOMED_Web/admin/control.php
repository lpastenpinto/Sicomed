<?php 
// Gestion Proinsa
// Desarrollado por: Felipe Suazo O.
// sad_sacrifice@hotmail.com
session_start();
session_name('sesion_admin_sicomed');
?>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000000;
}
body {
	background-color: #FFFFFF;
}
-->
</style>
<div align="center">
<?php 
if (!$HTTP_POST_VARS){
	echo 'Acceso al Archivo no Autorizado';
	session_destroy();
}else{
 		//Identifico Variables del Formulario
		$username = $HTTP_POST_VARS["username"];
		$userpass = md5($HTTP_POST_VARS["pass"]);
		//Comprobacion de Caracteres Permitidos
		 $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_";
		 for ($i=0; $i<strlen($username); $i++){ 
     	 if (strpos($permitidos, substr($username,$i,1))===false){ 
         	echo "Uso de Caracteres no Permitidos";
		 	session_destroy();
		 	echo '<a href="index.php">Volver</a>'; 
		 	exit;
		 }else{
		 }
		 }
		//Fin de Comprobacion
		//Inicio de Comprobacion de Usuario
		$main_pass = 'a384b6463fc216a5f8ecb6670f86456a';
		$main_user = 'admin';
		
		$secretaria_pass = 'a384b6463fc216a5f8ecb6670f86456a';
		$secretaria_user = 'secretaria';
		
		if($username == $main_user){
				if($main_pass==$userpass){
					session_register('admin_user'); 
					session_register('hora');
					session_register('level');
					session_register('id_admin');
					$date = getdate();
					$_SESSION["admin_user"]=$username;
					$_SESSION["hora"]=$date[hours].":".$date[minutes];
					$_SESSION["level"]=99999;
					$_SESSION["id_admin"]=1;
					echo 'Bienvenido, '.$_SESSION["admin_user"].'<br><br>';
					echo '<a href="home.php">[Entrar]</a>'; 
				}else{
					echo 'Usuario y Password No Concuerdan<br><br>';
					session_destroy();
					echo '<a href="index.php">[Volver]</a>';
				}
		}else if($username == $secretaria_user){
				if($secretaria_pass==$userpass){
					session_register('admin_user'); 
					session_register('hora');
					session_register('level');
					session_register('id_admin');
					$date = getdate();
					$_SESSION["admin_user"]=$username;
					$_SESSION["hora"]=$date[hours].":".$date[minutes];
					$_SESSION["level"]=0;
					$_SESSION["id_admin"]=2;
					echo 'Bienvenido, '.$_SESSION["admin_user"].'<br><br>';
					echo '<a href="home.php">[Entrar]</a>'; 
				}else{
					echo 'Usuario y Password No Concuerdan<br><br>';
					session_destroy();
					echo '<a href="index.php">[Volver]</a>';
				}
		}else{
	echo 'Usuario no Encontrado<br><br>';
	session_destroy();
	echo '<a href="index.php">Volver</a>';
		}
		//Fin de Comprobacion de Usuario
}
?> 
</div>