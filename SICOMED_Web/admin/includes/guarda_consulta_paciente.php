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
$couch_dsn = "http://miguelost:default@miguelost.cloudant.com/";
$couch_db = "sicomed";

require_once "couchDB/couch.php";
require_once "couchDB/couchClient.php";
require_once "couchDB/couchDocument.php";

try {
	$client = new couchClient($couch_dsn,$couch_db);
} catch (Exception $e) {
	echo "ERROR: ".$e->getMessage()." (".$e->getCode().")<br>\n";
}
	

$id_consulta = $HTTP_POST_VARS["consulta_id"];
$id = $HTTP_POST_VARS["idpaciente"];
$consulta_fecha = $HTTP_POST_VARS["consulta_fecha"];
$consulta_motivo = $HTTP_POST_VARS["consulta_motivo"];
$consulta_anam_prox = $HTTP_POST_VARS["consulta_anam_prox"];


// get the document
try {
    $paciente = $client->getDoc($id);
} catch (Exception $e) {
    echo "ERROR: ".$e->getMessage()." (".$e->getCode().")<br>\n";
}

// make changes
	$consultas = $paciente->motivo_consulta;

	$consultas[$id_consulta]->fecha = $consulta_fecha;
	$consultas[$id_consulta]->motivo = $consulta_motivo;
	$consultas[$id_consulta]->anam_prox = $consulta_anam_prox;

	$paciente->motivo_consulta = $consultas;

// update the document on CouchDB server
try {
    $response = $client->storeDoc($paciente);
} catch (Exception $e) {
    echo "ERROR: ".$e->getMessage()." (".$e->getCode().")<br>\n";
}
echo '<center><b>Datos Guardados</b></center><br><br>';

//echo "Doc recorded. id = ".$response->id." and revision = ".$response->rev."<br>\n";
// Doc recorded. id = BlogPost6576 and revision = 2-456769086
?>