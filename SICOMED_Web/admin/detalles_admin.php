<? session_start();
if (!isset($_SESSION["admin_user"]) && (session_name() != 'sesion_admin_proin')){ 
    include("index.php");
	exit;
}else{ 
	
} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

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
<script src="jscripts/jquery-1.6.4.js" type="text/javascript"></script>   

<script type="text/javascript" src="jscripts/jquery.validate.js"></script>

<script type="text/javascript">
		jQuery.noConflict();
		
		jQuery(document).ready(function(){
				jQuery("#editAdmin").validate()			
		 }); 
</script>
</head>

<body>
<?php 
include("includes/config.php");
	mysql_connect($hostdb,$userdb,$passdb);
	$consulta = "select * from admins where idadmins=".$_GET["view"]."";
	$result=mysql_db_query($db,$consulta);
	$row=mysql_fetch_array($result);
?>
<form id="editAdmin" action="includes/edit_admin.php" method="post">
<table width="500" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td align="center"><strong>Detalles Cuenta de Administrador</strong></td>
  </tr>
  <tr>
    <td align="right">Nombre de Usuario:
      <input name="username" type="text" id="username" style="width: 80px;" class="required" value="<?php echo $row["username"] ?>"/></td>
  </tr>
  <tr>
    <td align="right">Nivel:      
      <label>
        <select name="admin_level" id="admin_level">
          <option value="99" <?php if($row["level"] > 1){echo 'selected="selected"';} ?>>Administrador Maestro</option>
          <option value="1" <?php if($row["level"] == 1){echo 'selected="selected"';} ?>>Admnistrador Común</option>
        </select>
      </label></td>
  </tr>
  </table>
<p align="center">
	<input name="idadmins" id="idadmins" type="hidden" value="<?php echo $row["idamins"] ?>" />
  <input type="submit" name="Agregar" id="Agregar" value="Guardar" />
</p>
</form>
</body>
</html>