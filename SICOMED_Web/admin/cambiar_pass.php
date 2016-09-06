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

if($_POST){
	
	$n_pass = $HTTP_POST_VARS["new_password"];
	$n_pass_c = $HTTP_POST_VARS["new_password_c"];
	$idadmins = $HTTP_POST_VARS["idadmins"];
	
	$pass = md5($n_pass);
	$pass_c = md5(n_pass_c);
	
	if($pass == $pass_c){
		mysql_connect($hostdb,$userdb,$passdb);
		if(mysql_db_query($db, "UPDATE `admin` SET `pass` = '".$pass."' WHERE `idadmins` = '".$idadmins."' LIMIT 1 ")){
			echo '<center><b>Contraseña Guardada</b></center><br>';
		}else{
			echo '<center><b>Error</b></center><br><br>';
		}
	}else{
		echo '<center><b>Error</b> - Las contraseñas no coinciden</center><br><br>';
	}
}else{
?>
<form id="changePass" action="cambiar_pass.php" method="post">
<table width="500" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td align="center"><strong>Cambiar Contrase&ntilde;a de Cuenta</strong></td>
  </tr>
  <tr>
    <td align="right">Nueva Contrase&ntilde;a:
      <input name="new_password" type="password" id="new_password" style="width: 80px;"/></td>
  </tr>
  <tr>
    <td align="right">Repita Nueva Contrase&ntilde;a:
      <input name="new_password_c" type="password" id="new_password_c" style="width: 80px;"/></td>
  </tr>
  </table>
<p align="center">
	<input name="idadmins" id="idadmins" type="hidden" value="<?php echo $_SESSION["id_admin"] ?>" />
  <input type="submit" name="Agregar" id="Agregar" value="Guardar" />
</p>
</form>
<?php
}
?>