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
$ant_fam = $HTTP_POST_VARS["ant_fam"];
$habitos = $HTTP_POST_VARS["habitos"];
$medicamentos = $HTTP_POST_VARS["medicamentos"];

$alergias_alimentos = $HTTP_POST_VARS["alergias_alimentos"];
$alergias_sust_piel = $HTTP_POST_VARS["alergias_sust_piel"];
$alergias_medicamentos = $HTTP_POST_VARS["alergias_medicamentos"];
$alergias_picaduras = $HTTP_POST_VARS["alergias_picaduras"];
$alergias_sust_amb = $HTTP_POST_VARS["alergias_sust_amb"];

$ant_morb = $HTTP_POST_VARS["ant_morb"];

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
	$alergias = new stdClass();
		$alergias->alimentos = $alergias_alimentos;
		$alergias->sust_piel = $alergias_sust_piel;
		$alergias->medicamentos = $alergias_medicamentos;
		$alergias->picaduras = $alergias_picaduras;
		$alergias->sust_amb = $alergias_sust_amb;

	$antecedentes = new stdClass();
		$antecedentes->ant_fam = $ant_fam;
		$antecedentes->habitos = $habitos;
		$antecedentes->alergias = $alergias;
		$antecedentes->medicamentos = $medicamentos;
		$antecedentes->ant_morb = $ant_morb;
		
	$paciente->antecedentes = $antecedentes;


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