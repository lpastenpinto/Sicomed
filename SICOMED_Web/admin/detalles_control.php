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
$tratamientoid = $_GET["tratamientoid"];

try {
	$doc = $client->getDoc($id);
	
	$tratamientos = $doc->tratamiento;
	
	$tratamiento = $tratamientos[$tratamientoid];
	
	$controles = $tratamiento->control;
	
} catch (Exception $e) {
	if ( $e->code() == 404 ) {
		echo "Document not found\n";
	} else {
		echo "Error: ".$e->getMessage()." (errcode=".$e->getCode().")\n";
	}
	exit(1);
}

?>
<table width="70%" border="0" align="center" cellpadding="0" cellspacing="0">
          	  <tr>
          	    <td width="150" align="left" valign="top" bgcolor="#FFFFFF"><strong>Fechas</strong></td>
          	    <td colspan="5" align="left" valign="top" bgcolor="#FFFFFF"><strong>Datos Control</strong></td>
       	      </tr>
            <?php 
					for($i=count($controles)-1 ; $i >= 0 ; $i--) {
						$control = $controles[$i];
			?>          
            <tr>
          	      <td width="150" align="left" valign="top" bgcolor="#FFFFFF"><p>Fecha Control: <?php echo $control->fecha ?></p></td>
          	      <td width="100" align="right" valign="top" bgcolor="#FFFFFF">Evolucion:</td>
          	      <td colspan="4" align="left" valign="top" bgcolor="#FFFFFF"><?php echo $control->evolucion ?></td>
       	        </tr>
            <?php 
					}
			?>
            </table>
</body>
</html>