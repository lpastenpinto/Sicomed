<? session_start();
if (!isset($_SESSION["admin_user"]) && (session_name() != 'sesion_admin_sicomed')){ 
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
<link href="styles.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #FFF;
}
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000000;
}
-->
</style></head>

<body>
<form action="includes/agrega_control.php" method="post" enctype="multipart/form-data" id="addExamen">
  <table width="500" border="0" align="center" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF">
  <tr>
    <td align="center"><strong>Agregar Control</strong></td>
  </tr>
  <tr>
    <td align="center"><table width="430" border="0" cellpadding="2" cellspacing="2" >
      <tr>
        <td width="50%" align="right"><strong>Paciente</strong></td>
      </tr>
      <tr>
        <td align="right">R.U.T:
          
  <?php echo $_GET["view"] ?></td>
      </tr>
      <tr>
        <td align="right"><strong>Control</strong></td>
      </tr>
      <tr>
        <td width="50%" align="right"><strong>Fecha</strong>:
<label>
            <input type="text" name="n_control_fecha" id="n_control_fecha" />
          </label></td>
      </tr>
      <tr>
        <td align="right" valign="top"><strong>Evolución</strong>:
<label>
            <textarea name="n_control_evolucion" cols="40" rows="6" id="n_control_evolucion"></textarea>
          </label></td>
      </tr>
    </table></td>
  </tr>
  </table>
<p align="center">
  <input name="idpaciente" type="hidden" value="<?php echo $_GET["view"] ?>" />
  <input name="idtratamiento" type="hidden" value="<?php echo $_GET["tratamientoid"] ?>" />
  <input type="submit" name="Agregar" id="Agregar" value="Agregar" />
</p>
</form>
</body>
</html>