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
$idtratamiento = $HTTP_POST_VARS["idtratamiento"];

$n_control_fecha= $HTTP_POST_VARS["n_control_fecha"];
$n_control_evolucion = $HTTP_POST_VARS["n_control_evolucion"];

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
$doc = $client->getDoc($id);
	
$tratamientos = $doc->tratamiento;
	
$tratamiento = $tratamientos[$idtratamiento];
	
$controles = $tratamiento->control;

$controlesCount = count($controles);

$controles[$controlesCount]->fecha = $n_control_fecha;
$controles[$controlesCount]->evolucion = $n_control_evolucion;

$tratamiento->control = $controles;

$paciente->tratamiento = $tratamientos;

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