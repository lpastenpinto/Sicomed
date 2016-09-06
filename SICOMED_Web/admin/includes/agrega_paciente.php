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
$rut = $HTTP_POST_VARS["rut"];
$dv = $HTTP_POST_VARS["dv"];
$id = $rut.'-'.$dv;
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

	//$inter_consulta = new stdClass();
		/*$inter_consulta->resultados = "";
		$inter_consulta->motivo = "";
		$inter_consulta->especialidad = "";
		$inter_consulta->nombre_doctor = "";
		$inter_consulta->fecha_indicacion = "";
		$inter_consulta->fecha_resultados = "";*/
		
	//$motivo_consulta = new stdClass();
		/*$motivo_consulta->fecha = "";
		$motivo_consulta->motivo = "";
		$motivo_consulta->anam_prox = "";*/
		
	//$control = new stdClass();
		/*$control->fecha = "";
		$control->evolucion = "";*/
		
	//$tratamiento = new stdClass();
		/*$tratamiento->fecha = "";
		$tratamiento->control = array($control);
		$tratamiento->indicacion = "";*/
		
	$alergias = new stdClass();
		$alergias->alimentos = "";
		$alergias->sust_piel = "";
		$alergias->medicamentos = "";
		$alergias->picaduras = "";
		$alergias->sust_amb = "";

	$antecedentes = new stdClass();
		$antecedentes->ant_fam = "";
		$antecedentes->habitos = "";
		$antecedentes->alergias = $alergias;
		$antecedentes->medicamentos = "";
		$antecedentes->ant_morb = "";

	$paciente = new stdClass();
		$paciente->_id = $id;
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
		
		$paciente->antecedentes = $antecedentes;
		
		//$paciente->inter_consulta = array($inter_consulta);
		//$paciente->motivo_consulta = array($motivo_consulta);
		//$paciente->tratamiento = array($tratamiento);
		
		$paciente->inter_consulta = array();
		$paciente->motivo_consulta = array();
		$paciente->tratamiento = array();

try {
	$response = $client->storeDoc($paciente);
	
	echo '<center><b>Paciente agregado con éxito</b></center><br><br>';
} catch (Exception $e) {
	echo "Error: ".$e->getMessage()." (errcode=".$e->getCode().")\n";
	exit(1);
}
print_r($response);

			
	//	}else{
	//		echo '<center><b>Error</b></center><br><br>';
	//	}
?>