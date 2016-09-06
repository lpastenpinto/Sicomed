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
<script type="text/javascript" src="jscripts/jquery-1.6.4.js"></script>
<!--<script type="text/javascript" src="jscripts/jquery-1.4.3.min.js"></script> --->
<script type="text/javascript" src="jscripts/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="jscripts/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="jscripts/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<script type="text/javascript">
		$(document).ready(function() {
	   
			$(".editar_admin").fancybox({
				'width'				: '50%',
				'height'			: '40%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe',
				'onClosed': function() { parent.location.reload(true); ; } 
			});
			
			$(".borrar_admin").fancybox({
				'width'				: '50%',
				'height'			: '30%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe',
				'onClosed': function() { parent.location.reload(true); ; } 
			});
			
			$(".reset_pass").fancybox({
				'width'				: '40%',
				'height'			: '30%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
						 
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
    <td height="15" colspan="2" align="center" valign="top" bgcolor="#EEEEEE"><div align="right"><a href="home.php">Gestión Proinsa</a> &gt; Cuentas de Usuario<a href="personal.php"></a></div></td>
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
    <td width="1028" height="400" align="center" valign="top" bgcolor="#FFFFFF">
	<p>
	  <?php 
		include("includes/config.php");
		$ruta = $_SERVER[SCRIPT_URI];

		mysql_connect($hostdb,$userdb,$passdb);
		
		echo '<div align="center">';
		echo '<table width="80%" border="1" cellpadding="1" cellspacing="1"  bordercolor="#FFFFFF">
  				<tr class="Barra_Tabla">
    				<td bordercolor="#CCCCCC" width="25" align="center">ID</td>
					<td bordercolor="#CCCCCC" align="center">Nombre de Usuario</td>
					<td bordercolor="#CCCCCC" width="60" align="center">Privilegios</td>
					<td bordercolor="#CCCCCC" width="40" align="center">Editar</td>
					<td bordercolor="#CCCCCC" width="40" align="center">Reestablecer Contraseña</td>
					<td bordercolor="#CCCCCC" width="40" align="center">Eliminar</td>';
  		echo '		</tr>';
				
		$consulta = "select * from admins";

		$result=mysql_db_query($db,$consulta);
		
		$i = 0;
			while ($row=mysql_fetch_array($result)){
					echo '<tr>
							<td bordercolor="#CCCCCC">'.$row["idadmins"].'</td>
							<td bordercolor="#CCCCCC">'.$row["username"].'</td>
							<td bordercolor="#CCCCCC">';
							if($row["level"] > 1 && $row["idadmins"] == 1){
								echo 'Founder';
							}else if($row["level"] > 1){
								echo 'Administrador Maestro';
							}else{
								echo 'Administrador Comun';
							}
				if($row["idadmins"] == 1){
					echo '</td>
							<td bordercolor="#CCCCCC" align="center"><img src="images/icons/Lock.png" width="32" height="32" alt="Editar Cuenta" /></td>
							<td bordercolor="#CCCCCC" align="center"><img src="images/icons/Lock.png" width="32" height="32" alt="Reestablecer Contraseña" /></td>
							<td bordercolor="#CCCCCC" align="center"><img src="images/icons/Lock.png" width="32" height="32" alt="Borrar Cuenta" /></td>
					</tr>';
				}else{
					echo '</td>
							<td bordercolor="#CCCCCC" align="center"><a class="editar_admin" href="detalles_admin.php?view='.$row["idadmins"].'"><img src="images/icons/User-Edit.png" width="32" height="32" alt="Editar Cuenta" /></a></td>
							<td bordercolor="#CCCCCC" align="center"><a class="reset_pass" href="includes/reset_pass.php?view='.$row["idadmins"].'"><img src="images/icons/Key.png" width="32" height="32" alt="Reestablecer Contraseña" /></a></td>
							<td bordercolor="#CCCCCC" align="center"><a class="borrar_admin" href="includes/borrar_admin.php?view='.$row["idadmins"].'"><img src="images/icons/User-Delete.png" width="32" height="32" alt="Borrar Cuenta" /></a></td>
					</tr>';
				}
				$i++;
			}
		echo '</table>';
		echo '</div>';

?>
    </p></td>
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
