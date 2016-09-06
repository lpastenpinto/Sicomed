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
$nombre = $HTTP_POST_VARS["nombre"];
$apellido_paterno = $HTTP_POST_VARS["apellido_paterno"];
$apellido_materno = $HTTP_POST_VARS["apellido_materno"];
$nac_day = $HTTP_POST_VARS["day"];
$nac_month = $HTTP_POST_VARS["month"];
$nac_year = $HTTP_POST_VARS["year"];
$sexo = $HTTP_POST_VARS["sexo"];
$domicilio = $HTTP_POST_VARS["domicilio"];
$telefono = $HTTP_POST_VARS["telefono"];
$actividad = $HTTP_POST_VARS["actividad"];

$grupo_sanguineo = $HTTP_POST_VARS["grupo_sanguineo"];
$estatura = $HTTP_POST_VARS["estatura"];
$peso = $HTTP_POST_VARS["peso"];

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
$paciente->nombre = $nombre;
$paciente->apellido_paterno = $apellido_paterno;
$paciente->apellido_materno = $apellido_materno;
$paciente->nac_day = $nac_day;
$paciente->nac_month = $nac_month;
$paciente->nac_year = $nac_year;		
$paciente->sexo = $sexo;
$paciente->direccion = $domicilio;
$paciente->telefono = $telefono;
$paciente->actividad = $actividad;

$paciente->grupo_sangre = $grupo_sanguineo;
$paciente->estatura = $estatura;
$paciente->peso = $peso;


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