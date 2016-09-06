<? session_start();
if (!isset($_SESSION["admin_user"]) && (session_name() != 'sesion_admin_proin')){ 
    include("index.php");
	exit;
}else{ 
	
} 
?>
<style type="text/css">
<!--
body {
	color:#FFF;
}
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000000;
}
-->
</style>
<?php 
include("config.php");

$username = $HTTP_POST_VARS["username"];
$admin_level = $HTTP_POST_VARS["admin_level"];
$pass = md5('12345');

mysql_connect($hostdb,$userdb,$passdb);

if(mysql_db_query($db, "INSERT INTO admins VALUES ('idadmins','$username','$pass','$admin_level')")){
	echo '<center><b>Cuenta de Administrador Agregada</b></center><br><center>La contraseña por defecto es: 12345.</center><br>';
}else{
	echo '<center><b>Error</b></center><br><br>';
}
?>