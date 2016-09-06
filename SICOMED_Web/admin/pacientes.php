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
<title>Gestion Sicomed</title>
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
	   
								   
			$(".detalles").fancybox({
				'width'				: '80%',
				'height'			: '80%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
			$(".sube_examen").fancybox({
				'width'				: '60%',
				'height'			: '85%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
			$(".examenes").fancybox({
				'width'				: '95%',
				'height'			: '95%',
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
    <td height="15" colspan="2" align="center" valign="top" bgcolor="#EEEEEE"><div align="right"></div></td>
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
	
		echo '<div align="center">';
		echo '<table width="80%" border="1" cellpadding="1" cellspacing="1"  bordercolor="#FFFFFF">
  				<tr class="Barra_Tabla">
					<td bordercolor="#CCCCCC" width="100" align="center">Rut</td>
    				<td bordercolor="#CCCCCC">Nombre del Paciente</td>
					<td bordercolor="#CCCCCC" width="30" align="center">Datos Personales</td>
					<td bordercolor="#CCCCCC" width="30" align="center">Datos Clinicos</td>
					<td bordercolor="#CCCCCC" width="30" align="center">Agregar Examen</td>
    				<td bordercolor="#CCCCCC" width="30" align="center">Examenes</td>';
  		echo '		</tr>';
		
		$couch_dsn = "http://miguelost:default@miguelost.cloudant.com/";
		$couch_db = "sicomed";

		require_once "includes/couchDB/couch.php";
		require_once "includes/couchDB/couchClient.php";
		require_once "includes/couchDB/couchDocument.php";


		$client = new couchClient($couch_dsn,$couch_db);
		
		// MANTENER COMENTADO
		/*$view_fn="function(doc) { emit([doc.apellido_paterno, doc.apellido_materno, doc.nombre], null); }";
		$design_doc->_id = '_design/all';
		$design_doc->language = 'javascript';
		$design_doc->views = array ( 'list_by_id'=> array ('map' => $view_fn ) );
		$client->storeDoc($design_doc);*/
		
		//$all_docs = $client->getAllDocs(); LISTAR TODOS LOS DOCUMENTOS, SOLO LOS IDS
		$all_docs = $client->getView('all','list_by_id');
		
		foreach ( $all_docs->rows as $row ) {
			if( (strlen($row->id) == 10) || (strlen($row->id) == 9) ){
			echo '<tr>
						<td bordercolor="#CCCCCC">'.$row->id.'</td>
						<td bordercolor="#CCCCCC">'.$row->key[0].' '.$row->key[1].', '.$row->key[2].'</td>
						<td bordercolor="#CCCCCC" align="center"><a class="detalles" href="detalles_paciente.php?view='.$row->id.'"><img src="images/icons/Zoom.png" width="32" height="32" alt="Detalles Paciente" /></a></td>
						<td bordercolor="#CCCCCC" align="center">';
			if($_SESSION["level"] > 1){
				echo '		<a class="detalles" href="detalles_clinicos.php?view='.$row->id.'"><img src="images/icons/Health.png" width="32" height="32" alt="Detalles Clinicos" /></a>';
			}
			echo '		</td>
						<td bordercolor="#CCCCCC" align="center"><a class="sube_examen" href="agregar_examen.php?view='.$row->id.'"><img src="images/icons/Report-Add.png" width="32" height="32" alt="Agregar Examenes" /></a></td>
						<td bordercolor="#CCCCCC" align="center">';
			if($_SESSION["level"] > 1){
				echo '<a class="examenes" href="examenes.php?view='.$row->id.'"><img src="images/icons/Report.png" width="32" height="32" alt="Examenes" /></a>';
			}
			echo '</td>
					</tr>';
			}
		}
		echo '</table>';
		echo '</div>';

?>
</p>
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
