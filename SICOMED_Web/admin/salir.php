<?php 
session_start();
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
<? session_start();
if (!isset($_SESSION["admin_user"]) && (session_name() != 'sesion_admin_sicomed')){ 
    include("index.php");
	exit;
}else{ 
session_destroy();
echo 'Sesión Finalizada con Éxito.<br><br>';
echo '<a href="index.php">[Logearse Nuevamente]</a>';
exit;
} 
?>
</div>