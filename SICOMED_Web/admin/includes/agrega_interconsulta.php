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
$id = $HTTP_POST_VARS["idpaciente"];

$n_interconsulta_fecha_indicacion= $HTTP_POST_VARS["n_interconsulta_fecha_indicacion"];
$n_interconsulta_fecha_resultados = $HTTP_POST_VARS["n_interconsulta_fecha_resultados"];
$n_interconsulta_resultados = $HTTP_POST_VARS["n_interconsulta_resultados"];
$n_interconsulta_motivo = $HTTP_POST_VARS["n_interconsulta_motivo"];
$n_interconsulta_especialidad = $HTTP_POST_VARS["n_interconsulta_especialidad"];
$n_interconsulta_nombre_doctor = $HTTP_POST_VARS["n_interconsulta_nombre_doctor"];

$couch_dsn = "http://miguelost:default@miguelost.cloudant.com/";
$couch_db = "sicomed";

require_once "couchDB/couch.php";
require_once "couchDB/couchClient.php";
require_once "couchDB/couchDocument.php";

$client = new couchClient($couch_dsn,$couch_db);

// get the document
try {
    $paciente = $client->getDoc($id);
} catch (Exception $e) {
    echo "ERROR: ".$e->getMessage()." (".$e->getCode().")<br>\n";
}

// make changes
$inter_consultas = $paciente->inter_consulta;

$interconsultasCount = count($inter_consultas);

$inter_consultas[$interconsultasCount]->resultados = $n_interconsulta_resultados;
$inter_consultas[$interconsultasCount]->motivo = $n_interconsulta_motivo;
$inter_consultas[$interconsultasCount]->especialidad = $n_interconsulta_especialidad;
$inter_consultas[$interconsultasCount]->nombre_doctor = $n_interconsulta_nombre_doctor;
$inter_consultas[$interconsultasCount]->fecha_indicacion = $n_interconsulta_fecha_indicacion;
$inter_consultas[$interconsultasCount]->fecha_resultados = $n_interconsulta_fecha_resultados;

$paciente->inter_consulta = $inter_consultas;

// update the document on CouchDB server
try {
    $response = $client->storeDoc($paciente);
} catch (Exception $e) {
    echo "ERROR: ".$e->getMessage()." (".$e->getCode().")<br>\n";
}
echo '<center><b>Datos Guardados</b></center><br><br>';

			
	//	}else{
	//		echo '<center><b>Error</b></center><br><br>';
	//	}
?>