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

$pass = md5('12345');
				
mysql_connect($hostdb,$userdb,$passdb);
if(mysql_db_query($db, "UPDATE `admins` SET `pass` = '".$pass."' WHERE `idadmins` = '".$_GET["view"]."' LIMIT 1 ")){
	echo '<center><b>Datos Guardados</b></center><br><center>La contraseña por defecto es: 12345.</center><br>';
}else{
	echo '<center><b>Error</b></center><br><br>';
}
?>