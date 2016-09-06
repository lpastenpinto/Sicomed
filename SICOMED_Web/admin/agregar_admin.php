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
<title>Gestion Proinsa</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-image: url(images/bg.JPG);
}
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000000;
}
-->
</style>
<script src="jscripts/jquery-1.6.4.js" type="text/javascript"></script>   
<script type="text/javascript" src="jscripts/jquery.form.js"></script>

<script type="text/javascript" src="jscripts/jquery.validate.js"></script>

<script type="text/javascript"> 
		jQuery.noConflict();

        jQuery(document).ready(function() {
			var opciones= {
                			beforeSubmit: validate, //funcion que se ejecuta antes de enviar el form
                            success: mostrarRespuesta, //funcion que se ejecuta una vez enviado el formulario
							resetForm: true,
							   
            };
	
             //asignamos el plugin ajaxForm al formulario myForm y le pasamos las opciones
            jQuery('#addAdmin').ajaxForm(opciones) ; 
            
             //lugar donde defino las funciones que utilizo dentro de "opciones"
			 
             function validate(formData, jqForm, options) { 			 		
                      	jQuery("#loader_gif").fadeIn("slow");
						if(jQuery("#addAdmin").valid() == false){
							jQuery("#loader_gif").fadeOut("slow");
							return false;
						}
             };
             function mostrarRespuesta (responseText){
				          alert("Usuario Agregado Exitosamente");
                          jQuery("#loader_gif").fadeOut("slow");
						  $('#addAdmin').reset();
						  window.location.replace("usuarios.php");
             };
	
        }); 
</script> 
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="80" colspan="2" align="center" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="20%">&nbsp;</td>
          <td align="center" width="60%"><img src="images/logoweb.png" width="350" height="141" /></td>
          <td align="right" valign="bottom" width="20%">
		  <?php 
  include("includes/reloj.html");
  				$hoy = getdate();
				$mes = $hoy["mon"];
				$ano = $hoy["year"];
				$dia = $hoy["mday"];
  echo ''.$dia.'/'.$mes.'/'.$ano.'';
  ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td height="15" colspan="2" align="center" valign="top" bgcolor="#EEEEEE"><div align="right">
     
    </div></td>
  </tr>
  <tr>
    <td width="205" height="250" align="center" valign="top" bgcolor="#FFFFFF">
    <?php 
	if($_SESSION["level"] > 1){
		include("menu_admin.htm");
	}else{
		include("menu_user.htm");
	}
	?>
    </td>
    <td width="1028" height="250" align="center" valign="middle" bgcolor="#FFFFFF">
    <form id="addAdmin" action="includes/agrega_admin.php" method="post">
<table width="500" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td align="center"><strong>Agregar Cuenta de Administrador</strong></td>
  </tr>
  <tr>
    <td align="right">Nombre de Usuario:
      <input name="username" type="text" id="username" style="width: 80px;" class="required"/></td>
  </tr>
  <tr>
    <td align="right">Nivel:      
      <label>
        <select name="admin_level" id="admin_level">
          <option value="99">Administrador Maestro</option>
          <option value="1">Admnistrador Común</option>
        </select>
      </label></td>
  </tr>
  </table>
<p align="center">
  <input type="submit" name="Agregar" id="Agregar" value="Guardar" /><img id="loader_gif" src="images/loader.gif" style=" display:none;"/>
</p>
</form>
    </td>
  </tr>
</table>
<br />
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td><div align="center">
      <p>&copy; 2012 Sicomed<br />
It's True Services - Web Development </p>
    </div></td>
  </tr>
</table>
</body>
</html>
