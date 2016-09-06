<? session_start();
if (!isset($_SESSION["admin_user"]) && (session_name() != 'sesion_admin_sicomed')){ 
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

$idpaciente = $HTTP_POST_VARS["idpaciente"];
$n_examen = file_get_contents($HTTP_POST_FILES["n_examen"]['tmp_name']);

$n_examen_type = $HTTP_POST_FILES["n_examen"]["type"];
$n_examen_name = $HTTP_POST_FILES["n_examen"]["name"];

$couch_dsn = "http://miguelost:default@miguelost.cloudant.com/";
$couch_db = "sicomed";

require_once "couchDB/couch.php";
require_once "couchDB/couchClient.php";
require_once "couchDB/couchDocument.php";

$client = new couchClient($couch_dsn,$couch_db);


try {
	$doc = $client->getDoc($idpaciente);

	$response = $client->storeAsAttachment($doc,$n_examen,$n_examen_name,$n_examen_type);
	
	//print_r($response);
	
	echo '<center><b>Archivo Subido con éxito</b></center><br><br>';
} catch (Exception $e) {
	echo "Error: ".$e->getMessage()." (errcode=".$e->getCode().")\n";
	exit(1);
}

?>