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
	

$id_interconsulta = $HTTP_POST_VARS["interconsulta_id"];
$id = $HTTP_POST_VARS["idpaciente"];
$interconsulta_fecha_resultados = $HTTP_POST_VARS["interconsulta_fecha_resultados"];
$interconsulta_resultados = $HTTP_POST_VARS["interconsulta_resultados"];
$interconsulta_motivo = $HTTP_POST_VARS["interconsulta_motivo"];
$interconsulta_especialidad = $HTTP_POST_VARS["interconsulta_especialidad"];
$interconsulta_nombre_doctor = $HTTP_POST_VARS["interconsulta_nombre_doctor"];


// get the document
try {
    $paciente = $client->getDoc($id);
} catch (Exception $e) {
    echo "ERROR: ".$e->getMessage()." (".$e->getCode().")<br>\n";
}

// make changes
	$inter_consultas = $paciente->inter_consulta;
	
	$inter_consultas[$id_interconsulta]->fecha_resultados = $interconsulta_fecha_resultados;
	$inter_consultas[$id_interconsulta]->resultados = $interconsulta_resultados;
	$inter_consultas[$id_interconsulta]->motivo = $interconsulta_motivo;
	$inter_consultas[$id_interconsulta]->especialidad = $interconsulta_especialidad;
	$inter_consultas[$id_interconsulta]->nombre_doctor = $interconsulta_nombre_doctor;

	$paciente->inter_consulta = $inter_consultas;

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