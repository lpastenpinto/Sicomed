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
<script type="text/javascript" src="jscripts/jquery-1.6.4.js"></script>
<!--<script type="text/javascript" src="jscripts/jquery-1.4.3.min.js"></script> --->
<script type="text/javascript" src="jscripts/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="jscripts/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="jscripts/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<script type="text/javascript">
		$(document).ready(function() {
	   
								   
			$(".detalles").fancybox({
				'width'				: '100%',
				'height'			: '100%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
			$(".elimina_examen").fancybox({
				'width'				: '60%',
				'height'			: '85%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
			 
		});
</script>
</head>

<body>
<?php 

$couch_dsn = "http://miguelost:default@miguelost.cloudant.com/";
$couch_db = "sicomed";

require_once "includes/couchDB/couch.php";
require_once "includes/couchDB/couchClient.php";
require_once "includes/couchDB/couchDocument.php";

$client = new couchClient($couch_dsn,$couch_db);

$id = $_GET["view"];

try {
	$doc = $client->getDoc($id);
} catch (Exception $e) {
	if ( $e->code() == 404 ) {
		echo "Document not found\n";
	} else {
		echo "Error: ".$e->getMessage()." (errcode=".$e->getCode().")\n";
	}
	exit(1);
}

?>
  <table width="945" border="0" align="center" cellpadding="2" cellspacing="2">
    <tr>
      <td colspan="2" align="center"><strong>Examenes</strong></td>
    </tr>
    <tr>
      <td width="30%" height="20" align="right" valign="top">R.U.T: <?php echo $doc->_id ?></td>
      <td width="473" rowspan="3" align="center" valign="top">
	  <?php 
	  		echo '	<table width="90%" border="1" cellpadding="1" cellspacing="1"  bordercolor="#FFFFFF">
  							<tr>
    							<td bordercolor="#CCCCCC">Nombre</td>
   								<td bordercolor="#CCCCCC" width="30" align="center">Ver Examen</td>
    							<td bordercolor="#CCCCCC" width="30" align="center">Eliminar</td>
  							</tr>';
				
			$examenes = $doc->_attachments;
				
			foreach($examenes as $key => $value) {
				echo ' <tr>
    						<td>'.$key.'</td>
    						<td align="center"><a class="detalles" href="https://cloudant.com/db/miguelost/sicomed/'.$id.'/'.$key.'"><img src="images/icons/Zoom.png" width="32" height="32" alt="Ver Examenes" /></td>
    						<td align="center"><a class="elimina_examen" href="includes/borrar_examen.php?view='.$key.'&owner='.$id.'"><img src="images/icons/Delete.png" width="32" height="32" alt="Eliminar" /></td>
  						</tr>';
			}	
			echo '	</table>';
	 ?>
    </td>
    </tr>
    <tr>
      <td height="20" align="right" valign="top">Nombre: <?php echo $doc->apellido_paterno .' '. $doc->apellido_materno .', '. $doc->nombre?></td>
    </tr>
    <tr>
      <td align="center" valign="top">&nbsp;</td>
    </tr>
  </table>
</body>
</html>