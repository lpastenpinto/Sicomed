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

<script type="text/javascript" src="jscripts/vlacal/jslib/mootools-1.2-core-compressed.js"></script>
<script type="text/javascript" src="jscripts/vlacal/jslib/vlaCal-v2.1-compressed.js"></script>
<link type="text/css" media="screen" href="jscripts/vlacal/styles/vlaCal-v2.1.css" rel="stylesheet" />

<script type="text/javascript">
        window.addEvent('domready', function() {
            //Datepicker
			new vlaDatePicker('exampleIII',  { openWith: 'togglePicker', offset: { y: -2, x: 2 }, separateInput: { day: 'day', month: 'month', year: 'year' }, alignX: 'center', alignY: 'bottom', offset: { y: 3 }, prefillDate: 'false', filePath: 'jscripts/vlacal/inc/' });
        });
</script>

<script src="jscripts/jquery-1.6.4.js" type="text/javascript"></script>   

<script type="text/javascript" src="jscripts/jquery.validate.js"></script>

<script type="text/javascript">
		jQuery.noConflict();
		
		jQuery(document).ready(function(){
				jQuery("#editPaciente").validate()			
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
<form id="editPaciente" action="includes/edit_paciente.php" method="post">
  <table width="945" border="0" align="center" cellpadding="2" cellspacing="2">
    <tr>
      <td colspan="2" align="center"><strong>Datos Personales Paciente</strong></td>
    </tr>
    <tr>
      <td width="458" align="center" valign="top"><table width="438" border="0" cellpadding="2" cellspacing="2" >
        <tr>
          <td align="center"><strong>Antecedentes personales</strong></td>
        </tr>
        <tr>
          <td align="right">R.U.N. : <?php echo $doc->_id ?></td>
        </tr>
        <tr>
          <td align="right">Nombres:
            <input name="nombre" type="text"  id="nombre" class="required" value="<?php echo $doc->nombre ?>"/></td>
        </tr>
        <tr>
          <td align="right">Apellido Paterno:
            <input name="apellido_paterno" type="text"  id="apellido_paterno" class="required" value="<?php echo $doc->apellido_paterno ?>"/></td>
        </tr>
        <tr>
          <td align="right">Apellido Materno:
            <input name="apellido_materno" type="text"  id="apellido_materno" class="required" value="<?php echo $doc->apellido_materno ?>"/></td>
        </tr>
        <tr>
          <td align="right">Fecha de Nacimiento: <span id="exampleIII">
            <input name="day" type="text" style="width: 18px; border-width: 1px 0 1px 1px;" maxlength="2" value="<?php echo $doc->nac_day ?>"/>
            <input value="/" type="text" style="width: 5px; border-width: 1px 0 1px 0;" disabled="disabled" />
            <input name="month" class="textbox" type="text" style="width: 16px; border-width: 1px 0 1px 0;" maxlength="2" value="<?php echo $doc->nac_month ?>"/>
            <input value="/" type="text" style="width: 5px; border-width: 1px 0 1px 0;" disabled="disabled" />
            <input name="year" type="text" style="width: 28px; border-width: 1px 0 1px 0;" maxlength="4" value="<?php echo $doc->nac_year ?>"/>
            <input type="text" style="width: 15px; border-width: 1px 1px 1px 0;" disabled="disabled" />
            <img src="jscripts/vlacal/images/calendar.gif" id="togglePicker" class="pickerImg" width="13" height="12" alt="" /> </span></td>
        </tr>
        <tr>
          <td align="right">Sexo:
            <label>
              <select name="sexo" id="sexo">
                <option value="M" <?php if($doc->sexo == 'M'){echo 'selected="selected"';}?>>Masculino</option>
                <option value="F" <?php if($doc->sexo == 'F'){echo 'selected="selected"';}?>>Femenimo</option>
              </select>
            </label></td>
        </tr>
        <tr>
          <td align="right">Domicilio:
            <input name="domicilio" type="text"  id="domicilio" class="required" value="<?php echo $doc->direccion ?>"/></td>
        </tr>
        <tr>
          <td align="right">Telefono:
            <input name="telefono" type="text"  id="telefono" class="required number" value="<?php echo $doc->telefono ?>"/></td>
        </tr>
        <tr>
          <td align="right">Actividad:
            <label>
              <select name="actividad" id="actividad">
                <option value="Estudiante" <?php if($doc->actividad == 'Estudiante'){echo 'selected="selected"';}?>>Estudiante</option>
                <option value="Trabajador Dependiente" <?php if($doc->actividad == 'Trabajador Dependiente'){echo 'selected="selected"';}?>>Trabajador Dependiente</option>
                <option value="Trabajador Independiente" <?php if($doc->actividad == 'Trabajador Independiente'){echo 'selected="selected"';}?>>Trabajador Independiente</option>
                <option value="Jubilado" <?php if($doc->actividad == 'Jubilado'){echo 'selected="selected"';}?>>Jubilado</option>
                <option value="Desempleado" <?php if($doc->actividad == 'Desempleado'){echo 'selected="selected"';}?>>Desempleado</option>
              </select>
            </label></td>
        </tr>
      </table></td>
      <td width="473" align="center" valign="top"><table width="467" border="0" align="center" cellpadding="2" cellspacing="2" >
        <tr>
          <td width="441" align="center" class="LOGINbox"><strong>Antecedentes Médicos</strong></td>
        </tr>
        <tr>
          <td align="right">Grupo Sangineo:
            <select name="grupo_sanguineo" id="grupo_sanguineo">
              <option value="A" <?php if($doc->grupo_sangre == 'A'){echo 'selected="selected"';}?>>Grupo A</option>
              <option value="B" <?php if($doc->grupo_sangre == 'B'){echo 'selected="selected"';}?>>Grupo B</option>
              <option value="AB" <?php if($doc->grupo_sangre == 'AB'){echo 'selected="selected"';}?>>Grupo AB</option>
              <option value="0" <?php if($doc->grupo_sangre == '0'){echo 'selected="selected"';}?>>Grupo 0</option>
            </select></td>
        </tr>
        <tr>
          <td align="right">Estatura:
            <input name="estatura" type="text"  id="estatura" class="required" value="<?php echo $doc->estatura ?>"/></td>
        </tr>
        <tr>
          <td align="right">Peso:
            <input name="peso" type="text"  id="peso" class="required" value="<?php echo $doc->peso ?>"/></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  </table>
  <p align="center">
  <input type="hidden" name="idpaciente" id="idpaciente" value="<?php echo $doc->_id ?>"/>
    <input type="submit" name="button" id="button" value="Guardar Cambios" />
</p>
</form>
</body>
</html>