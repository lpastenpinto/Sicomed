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
<link href="styles.css" rel="stylesheet" type="text/css" />
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

<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>

<script src="jscripts/jquery-1.6.4.js" type="text/javascript"></script>   

<script type="text/javascript" src="jscripts/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="jscripts/fancybox/jquery.fancybox-1.3.4.pack.js"></script>


<script type="text/javascript" src="jscripts/jquery.form.js"></script>   

<script type="text/javascript" src="jscripts/jquery.validate.js"></script>
<script src="SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<script type="text/javascript">
		jQuery.noConflict();

		jQuery(document).ready(function(){
										
			jQuery(".ver_controles").fancybox({
				'width'				: '60%',
				'height'			: '60%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
			jQuery(".nuevo_control").fancybox({
				'width'				: '60%',
				'height'			: '85%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
			
			jQuery(".Tratamientos_DeleteButton").click(function(){
				var currentTratamiento = jQuery(this).attr('id');
				
				//currentInterConsulta = currentInterConsulta.substring(0, currentInterConsulta.length-1);
				
				var splittedCurrentTratamiento = currentTratamiento.split('_');
				
				var idTratamiento = splittedCurrentTratamiento[1];
				
				var idPaciente = jQuery("#idpaciente").val();
																	 
				jQuery.get("includes/borrar_tratamiento.php", { idpaciente: idPaciente, tratamiento_id: idTratamiento }, function(data) {
					location.replace(document.URL+'&tab=2');																										
				});
															 
			});
										
			var optionsAddTratamiento = {
                		beforeSubmit: addTrat_checkFields, //funcion que se ejecuta antes de enviar el form
                        success: addTrat_succesfulSave, //funcion que se ejecuta una vez enviado el formulario
						resetForm: true,
            };
			//asignamos el plugin ajaxForm al formulario myForm y le pasamos las opciones
            jQuery('#newTratamientoForm').ajaxForm(optionsAddTratamiento); 
             
            function addTrat_checkFields(formData, jqForm, options) { 			 		
				if(jQuery("#newTratamientoForm").valid() == false){
					return false;
				}
            };
            function addTrat_succesfulSave(responseText){
				alert("Nuevo Tratamiento Guardado");
				location.replace(document.URL+'&tab=3');
            };							
										
			jQuery(".InterConsultas_DeleteButton").click(function(){
				var currentInterConsulta = jQuery(this).attr('id');
				
				//currentInterConsulta = currentInterConsulta.substring(0, currentInterConsulta.length-1);
				
				var splittedCurrentInterConsulta = currentInterConsulta.split('_');
				
				var idInterConsulta = splittedCurrentInterConsulta[1];
				
				var idPaciente = jQuery("#idpaciente").val();
																	 
				jQuery.get("includes/borrar_interconsulta.php", { idpaciente: idPaciente, interconsulta_id: idInterConsulta }, function(data) {
					location.replace(document.URL+'&tab=2');																										
				});
															 
			});
			
			var optionsSaveInterConsulta = {
                		beforeSubmit: saveInter_checkFields, //funcion que se ejecuta antes de enviar el form
                        success: saveInter_succesfulSave, //funcion que se ejecuta una vez enviado el formulario						   
            };
			//asignamos el plugin ajaxForm al formulario myForm y le pasamos las opciones
            jQuery('.editInterConsultaForm').ajaxForm(optionsSaveInterConsulta); 
             
            function saveInter_checkFields(formData, jqForm, options) { 			 		
				if(jQuery(".editInterConsultaForm").valid() == false){
					return false;
				}
            };
            function saveInter_succesfulSave(responseText){
				alert("Cambios Guardados");
				location.replace(document.URL+'&tab=1');
            };
			
			var optionsAddInterConsulta = {
                		beforeSubmit: addInter_checkFields, //funcion que se ejecuta antes de enviar el form
                        success: addInter_succesfulSave, //funcion que se ejecuta una vez enviado el formulario
						resetForm: true,
            };
			//asignamos el plugin ajaxForm al formulario myForm y le pasamos las opciones
            jQuery('#newInterConsultaForm').ajaxForm(optionsAddInterConsulta); 
             
            function addInter_checkFields(formData, jqForm, options) { 			 		
				if(jQuery("#newInterConsultaForm").valid() == false){
					return false;
				}
            };
            function addInter_succesfulSave(responseText){
				alert("Nueva Inter Consulta Guardada");
				location.replace(document.URL+'&tab=2');
            };
			
			jQuery(".Consultas_DeleteButton").click(function(){
				var currentConsulta = jQuery(this).attr('id');
				
				var splittedCurrentConsulta = currentConsulta.split('_');
				
				var idConsulta = splittedCurrentConsulta[1];
				
				var idPaciente = jQuery("#idpaciente").val();
																	 
				jQuery.get("includes/borrar_consulta.php", { idpaciente: idPaciente, consulta_id: idConsulta }, function(data) {
					location.replace(document.URL+'&tab=0');																										
				});
															 
			});							
										
			var optionsSaveConsulta = {
                		beforeSubmit: save_checkFields, //funcion que se ejecuta antes de enviar el form
                        success: save_succesfulSave, //funcion que se ejecuta una vez enviado el formulario						   
            };
			//asignamos el plugin ajaxForm al formulario myForm y le pasamos las opciones
            jQuery('.editConsultaForm').ajaxForm(optionsSaveConsulta); 
             
            function save_checkFields(formData, jqForm, options) { 			 		
				if(jQuery(".editConsultaForm").valid() == false){
					return false;
				}
            };
            function save_succesfulSave(responseText){
				alert("Cambios Guardados");
				location.replace(document.URL+'&tab=0');
            };
			
			var optionsAddConsulta = {
                		beforeSubmit: add_checkFields, //funcion que se ejecuta antes de enviar el form
                        success: add_succesfulSave, //funcion que se ejecuta una vez enviado el formulario
						resetForm: true,
            };
			//asignamos el plugin ajaxForm al formulario myForm y le pasamos las opciones
            jQuery('#newConsultaForm').ajaxForm(optionsAddConsulta); 
             
            function add_checkFields(formData, jqForm, options) { 			 		
				if(jQuery("#newConsultaForm").valid() == false){
					return false;
				}
            };
            function add_succesfulSave(responseText){
				alert("Nueva Consulta Guardada");
				location.replace(document.URL+'&tab=0');
            };
			
			var optionsSaveAntecedentes = {
                        success: saveAnt_succesfulSave, //funcion que se ejecuta una vez enviado el formulario						   
            };
			//asignamos el plugin ajaxForm al formulario myForm y le pasamos las opciones
            jQuery('#editAntecedentesPaciente').ajaxForm(optionsSaveAntecedentes); 

            function saveAnt_succesfulSave(responseText){
				alert("Cambios Guardados");
            };
		 }); 
</script>
<link rel="stylesheet" type="text/css" href="jscripts/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php 
// To Select TAB !!! by FSO.
if($_GET["tab"] == ''){
	$_GET["tab"] = 0;
}
/// END

$couch_dsn = "http://miguelost:default@miguelost.cloudant.com/";
$couch_db = "sicomed";

require_once "includes/couchDB/couch.php";
require_once "includes/couchDB/couchClient.php";
require_once "includes/couchDB/couchDocument.php";

$client = new couchClient($couch_dsn,$couch_db);

$id = $_GET["view"];

try {
	$doc = $client->getDoc($id);
	
	$antecedentes = $doc->antecedentes;
	$alergias = $antecedentes->alergias;
	$consultas = $doc->motivo_consulta;
	$inter_consultas = $doc->inter_consulta;
	$tratamientos = $doc->tratamiento;
	
} catch (Exception $e) {
	if ( $e->code() == 404 ) {
		echo "Document not found\n";
	} else {
		echo "Error: ".$e->getMessage()." (errcode=".$e->getCode().")\n";
	}
	exit(1);
}

?>
  <table width="945" border="0" align="center" cellpadding="2" cellspacing="2">
    <tr>
      <td align="center" bgcolor="#FFFFFF"><strong>Datos Clinicos Pacientes</strong></td>
    </tr>
    <tr>
      <td align="right" bgcolor="#FFFFFF"><p>R.U.N. : <?php echo $doc->_id ?></p>
      <p>Nombre: <?php echo $doc->apellido_paterno .' '. $doc->apellido_materno .', '. $doc->nombre?></p></td>
    </tr>
    <tr>
      <td width="150" height="30" align="center" valign="top" bgcolor="#FFFFFF"><div id="detalles_clinicos" class="TabbedPanels">
        <ul class="TabbedPanelsTabGroup">
          <li class="TabbedPanelsTab" tabindex="0">Consultas</li>
          <li class="TabbedPanelsTab" tabindex="0">Amnesis Remota</li>
<li class="TabbedPanelsTab" tabindex="0">Inter Consultas</li>
          <li class="TabbedPanelsTab" tabindex="0">Tratamientos</li>
        </ul>
        <div class="TabbedPanelsContentGroup">
          <div class="TabbedPanelsContent">
            <div id="addConsulta" class="CollapsiblePanel">
              <div class="CollapsiblePanelTab" tabindex="0" style="height:30px;background-image:url(images/icons/Add.png);background-position:right;background-repeat:no-repeat;"></div>
              <div class="CollapsiblePanelContent">
                <form id="newConsultaForm" name="newConsultaForm" method="post" action="includes/agrega_consulta.php">
                  <table width="90%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="150" align="right" valign="top"><strong>Fecha:</strong></td>
                      <td><input type="text" name="n_consulta_fecha" id="n_consulta_fecha" /></td>
                    </tr>
                    <tr>
                      <td width="150" align="right" valign="top"><strong>Motivo:</strong></td>
                      <td><textarea name="n_consulta_motivo" cols="70" rows="5" id="n_consulta_motivo"><?php echo $consulta->motivo ?></textarea></td>
                    </tr>
                    <tr>
                      <td width="150" align="right" valign="top"><strong>Anamnesis Proxima:</strong></td>
                      <td><textarea name="n_consulta_anam_prox" cols="70" rows="5" id="n_consulta_anam_prox"><?php echo $consulta->anam_prox ?></textarea></td>
                    </tr>
                    <tr>
                      <td width="150" align="right" valign="top">&nbsp;</td>
                      <td align="right"><input name="idpaciente" type="hidden" value="<?php echo $doc->_id ?>"/>
                        <label>
                          <input type="submit" name="saveNConsultaButton" id="saveNConsultaButton" value="Guardar" />
                        </label></td>
                    </tr>
                  </table>
                </form>
              </div>
            </div>
            <table width="90%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="150" align="left" valign="top" bgcolor="#FFFFFF"><strong>Fecha</strong></td>
                <td colspan="2" align="left" valign="top" bgcolor="#FFFFFF"><strong>Datos Consulta</strong></td>
                <td width="30" align="left" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
                <td width="30" align="left" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
              <?php 
					for($i=count($consultas)-1 ; $i >= 0 ; $i--) {
						$consulta = $consultas[$i];
						if($consulta->fecha != null){
				?>
              <form class="editConsultaForm" id="editConsulta_<?php echo $i ?>" name="editConsulta_<?php echo $i ?>" action="includes/guarda_consulta_paciente.php" method="post">
                <tr>
                  <td width="150" rowspan="2" align="left" valign="top" bgcolor="#FFFFFF">Fecha: <?php echo $consulta->fecha ?></td>
                  <td width="100" align="right" valign="top" bgcolor="#FFFFFF">Motivo:</td>
                  <td align="left" valign="top" bgcolor="#FFFFFF"><label>
                    <textarea name="consulta_motivo" cols="70" rows="5" readonly="readonly" id="consulta<?php echo $i ?>_motivo"><?php echo $consulta->motivo ?></textarea>
                  </label></td>
                  <td width="30" rowspan="2" align="left" valign="top" bgcolor="#FFFFFF"><label>
                    <input type="hidden" name="consulta_id" id="consulta<?php echo $i ?>_id" value="<?php echo $i ?>"/>
                    <input type="hidden" name="idpaciente" id="consulta<?php echo $i ?>_idpaciente" value="<?php echo $doc->_id ?>"/>
                    <input style="visibility:hidden;" class="Consultas_SaveButton" type="submit" name="saveButton_<?php echo $i ?>" id="saveButton_<?php echo $i ?>" value="" />
                  </label></td>
                  <td width="30" rowspan="2" align="left" valign="top" bgcolor="#FFFFFF"><input style="visibility:hidden;" class="Consultas_DeleteButton" type="button" name="deleteButton_<?php echo $i ?>" id="deleteButton_<?php echo $i ?>" value="" disabled="disabled"/></td>
                </tr>
                <tr>
                  <td width="100" align="right" valign="top" bgcolor="#FFFFFF">Anamnesis Proxima:</td>
                  <td bgcolor="#FFFFFF"><textarea name="consulta_anam_prox" cols="70" rows="5" readonly="readonly" id="consulta_anam_prox"><?php echo $consulta->anam_prox ?></textarea></td>
                </tr>
              </form>
              <?php 
						}else{
						}
					}
				?>
            </table><p>&nbsp;</p>
            
          </div>
          <div class="TabbedPanelsContent">
            <form id="editAntecedentesPaciente" action="includes/guarda_antecedentes_paciente.php" method="post">
              <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="200" align="right" valign="top">Antecedentes Familiares:</td>
                  <td align="left" valign="top"><label>
                    <textarea name="ant_fam" cols="80" rows="6" id="ant_fam"><?php echo $antecedentes->ant_fam ?></textarea>
                  </label></td>
                </tr>
                <tr>
                  <td align="right" valign="top">Habitos:</td>
                  <td align="left" valign="top"><textarea name="habitos" cols="80" rows="6" id="habitos"><?php echo $antecedentes->habitos ?></textarea></td>
                </tr>
                <tr>
                  <td align="right" valign="top">Medicamentos:</td>
                  <td align="left" valign="top"><textarea name="medicamentos" cols="80" rows="6" id="medicamentos"><?php echo $antecedentes->medicamentos ?></textarea></td>
                </tr>
                <tr>
                  <td align="right" valign="top">Alergias:</td>
                  <td align="left" valign="top"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="200" align="right" valign="top">Alimentos:</td>
                      <td><label>
                        <textarea name="alergias_alimentos" cols="67" rows="4" id="alergias_alimentos"><?php echo $alergias->alimentos ?></textarea>
                      </label></td>
                    </tr>
                    <tr>
                      <td width="200" align="right" valign="top">Sustacias Piel:</td>
                      <td><textarea name="alergias_sust_piel" cols="67" rows="4" id="alergias_sust_piel"><?php echo $alergias->sust_piel ?></textarea></td>
                    </tr>
                    <tr>
                      <td width="200" align="right" valign="top">Medicamentos:</td>
                      <td><textarea name="alergias_medicamentos" cols="67" rows="4" id="alergias_medicamentos"><?php echo $alergias->medicamentos ?></textarea></td>
                    </tr>
                    <tr>
                      <td width="200" align="right" valign="top">Picaduras:</td>
                      <td><textarea name="alergias_picaduras" cols="67" rows="4" id="alergias_picaduras"><?php echo $alergias->picaduras ?></textarea></td>
                    </tr>
                    <tr>
                      <td width="200" align="right" valign="top">Sustancias Ambientales:</td>
                      <td><textarea name="alergias_sust_amb" cols="67" rows="4" id="alergias_sust_amb"><?php echo $alergias->sust_amb ?></textarea></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td align="right" valign="top">Antecedentes Morbidos:</td>
                  <td align="left" valign="top"><textarea name="ant_morb" cols="80" rows="6" id="ant_morb"><?php echo $antecedentes->ant_morb ?></textarea></td>
                </tr>
              </table>
              <input type="hidden" name="idpaciente" id="idpaciente" value="<?php echo $doc->_id ?>"/>
              <input type="submit" name="saveAntecedentesButton" id="saveAntecedentesButton" value="Guardar Cambios" />
            </form>
          </div>
		<div class="TabbedPanelsContent">
			<div id="addInter_Consulta" class="CollapsiblePanel">
          	  <div class="CollapsiblePanelTab" tabindex="0" style="height:30px;background-image:url(images/icons/Add.png);background-position:right;background-repeat:no-repeat;"></div>
          	  <div class="CollapsiblePanelContent">
          	    <form id="newInterConsultaForm" name="newInterConsultaForm" method="post" action="includes/agrega_interconsulta.php">
                  <table width="90%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="150" align="right" valign="top"><strong>Resultados:</strong></td>
                      <td><textarea name="n_interconsulta_resultados" cols="70" rows="5" readonly="readonly" id="n_interconsulta_resultados">En espera...</textarea></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top"><strong>Motivo:</strong></td>
                      <td><textarea name="n_interconsulta_motivo" cols="70" rows="5" id="n_interconsulta_motivo"></textarea></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top"><strong>Especialidad:</strong></td>
                      <td><input type="text" name="n_interconsulta_especialidad" id="n_interconsulta_especialidad" /></td>
                    </tr>
                    <tr>
                      <td width="150" align="right" valign="top"><strong>Nombre Doctor:</strong></td>
                      <td><input name="n_interconsulta_nombre_doctor" type="text" id="n_interconsulta_nombre_doctor" value="En espera..." size="30" readonly="readonly" /></td>
                    </tr>
                    <tr>
                      <td width="150" align="right" valign="top"><strong>Fecha Indicacion:</strong></td>
                      <td><input type="text" name="n_interconsulta_fecha_indicacion" id="n_interconsulta_fecha_indicacion" /></td>
                    </tr>
                    <tr>
                      <td width="150" align="right" valign="top"><strong>Fecha Resultados:</strong></td>
                      <td><input name="n_interconsulta_fecha_resultados" type="text" id="n_interconsulta_fecha_resultados" value="En espera..." readonly="readonly" /></td>
                    </tr>
                    <tr>
                      <td width="150" align="right" valign="top">&nbsp;</td>
                      <td align="right">
                      <input name="idpaciente" type="hidden" value="<?php echo $doc->_id ?>"/>
                      <label>
                        <input type="submit" name="saveNInterConsultaButton" id="saveNInterConsultaButton" value="Guardar" />
                      </label></td>
                    </tr>
              </table>
            </form>
       	      </div>
       	    </div>
          	<p>&nbsp;</p>
          	<table width="90%" border="0" cellpadding="0" cellspacing="0">
          	  <tr>
          	    <td width="150" align="left" valign="top" bgcolor="#FFFFFF"><strong>Fechas</strong></td>
          	    <td colspan="2" align="left" valign="top" bgcolor="#FFFFFF"><strong>Datos Inter Consulta</strong></td>
          	    <td width="30" align="left" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
          	    <td width="30" align="left" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
       	      </tr>
            <?php 
					for($i=count($inter_consultas)-1 ; $i >= 0 ; $i--) {
						$inter_consulta = $inter_consultas[$i];
						if($inter_consulta->fecha_indicacion != null){
			?>
            <form class="editInterConsultaForm" id="editInterConsulta_<?php echo $i ?>" name="editInterConsulta_<?php echo $i ?>" action="includes/guarda_interconsulta_paciente.php" method="post">
            <tr>
          	      <td width="150" rowspan="4" align="left" valign="top" bgcolor="#FFFFFF"><p>Fecha Indicacion: <?php echo $inter_consulta->fecha_indicacion ?></p>
       	          <p>Fecha Resultados: <input name="interconsulta_fecha_resultados" id="interconsulta_fecha_resultados" <?php if(strtoupper($inter_consulta->fecha_resultados) != strtoupper('En espera...')){ ?>readonly="readonly"<?php } ?>  type="text" value="<?php echo $inter_consulta->fecha_resultados ?>"/></p></td>
          	      <td width="100" align="right" valign="top" bgcolor="#FFFFFF">Resultados:</td>
          	      <td align="left" valign="top" bgcolor="#FFFFFF"><label>
          	        <textarea name="interconsulta_resultados" cols="70" rows="5" <?php if(strtoupper($inter_consulta->resultados) != strtoupper('En espera...')){ ?>readonly="readonly" <?php } ?>id="interconsulta_resultados"><?php echo $inter_consulta->resultados ?></textarea>
        	        </label></td>
          	      <td width="30" rowspan="4" align="left" valign="top" bgcolor="#FFFFFF"><label>
          	        <input type="hidden" name="interconsulta_id" id="interconsulta_id" value="<?php echo $i ?>"/>
          	        <input type="hidden" name="idpaciente" id="idpaciente" value="<?php echo $doc->_id ?>"/>
          	        <input <?php if(strtoupper($inter_consulta->fecha_resultados) != strtoupper('En espera...')){ ?> style="visibility:hidden;" <?php } ?>class="Consultas_SaveButton" type="submit" name="saveInterButton_<?php echo $i ?>2" id="saveInterButton_<?php echo $i ?>2" value="" />
        	        </label></td>
          	      <td width="30" rowspan="4" align="left" valign="top" bgcolor="#FFFFFF"><input style="visibility:hidden;" class="InterConsultas_DeleteButton" type="button" name="deleteInterButton_<?php echo $i ?>" id="deleteInterButton_<?php echo $i ?>" value="" disabled="disabled"/></td>
       	        </tr>
          	    <tr>
          	      <td width="100" align="right" valign="top" bgcolor="#FFFFFF">Motivo:</td>
          	      <td bgcolor="#FFFFFF"><textarea name="interconsulta_motivo" cols="70" rows="5" readonly="readonly" id="interconsulta_motivo"><?php echo $inter_consulta->motivo ?></textarea></td>
       	        </tr>
          	    <tr>
          	      <td width="100" align="right" valign="top" bgcolor="#FFFFFF">Especialidad:</td>
          	      <td bgcolor="#FFFFFF"><label>
          	        <input name="interconsulta_especialidad" type="text" id="interconsulta_especialidad" value="<?php echo $inter_consulta->especialidad ?>" readonly="readonly"/>
       	          </label></td>
       	        </tr>
          	    <tr>
          	      <td width="100" align="right" valign="top" bgcolor="#FFFFFF">Nombre Doctor:</td>
          	      <td height="50" align="left" valign="top" bgcolor="#FFFFFF"><label>
          	        <input name="interconsulta_nombre_doctor" type="text" id="interconsulta_nombre_doctor" value="<?php echo $inter_consulta->nombre_doctor ?>" <?php if(strtoupper($inter_consulta->nombre_doctor) != strtoupper('En espera...')){ ?> readonly="readonly" <?php } ?>/>
       	          </label></td>
       	        </tr>
            </form>
            <?php 
						}else{
						}
					}
			?>
            </table>
          </div>
          <div class="TabbedPanelsContent">
          	<div id="addTratamiento" class="CollapsiblePanel">
          	  <div class="CollapsiblePanelTab" tabindex="0" style="height:30px;background-image:url(images/icons/Add.png);background-position:right;background-repeat:no-repeat;"></div>
          	  <div class="CollapsiblePanelContent">
          	    <form id="newTratamientoForm" name="newTratamientoForm" method="post" action="includes/agrega_tratamiento.php">
                  <table width="90%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="150" align="right" valign="top"><strong>Indicacion:</strong></td>
                      <td><textarea name="n_tratamiento_indicacion" cols="70" rows="5" id="n_tratamiento_indicacion"></textarea></td>
                    </tr>
                    <tr>
                      <td width="150" align="right" valign="top"><strong>Fecha:</strong></td>
                      <td><input type="text" name="n_tratamiento_fecha" id="n_tratamiento_fecha" /></td>
                    </tr>
                    <tr>
                      <td width="150" align="right" valign="top">&nbsp;</td>
                      <td align="right">
                      <input name="idpaciente" type="hidden" value="<?php echo $doc->_id ?>"/>
                      <label>
                        <input type="submit" name="saveNTratamientoButton" id="saveNTratamientoButton" value="Guardar" />
                      </label></td>
                    </tr>
              </table>
            </form>
       	      </div>
       	    </div>
          	<p>&nbsp;</p>
          	<table width="90%" border="0" cellpadding="0" cellspacing="0">
          	  <tr>
          	    <td width="150" align="left" valign="top" bgcolor="#FFFFFF"><strong>Fechas</strong></td>
          	    <td colspan="2" align="left" valign="top" bgcolor="#FFFFFF"><strong>Datos Tratamiento</strong></td>
          	    <td width="15" align="left" valign="top" bgcolor="#FFFFFF"><strong>Ver Controles</strong></td>
          	    <td width="15" align="left" valign="top" bgcolor="#FFFFFF"><strong>Agregar Control</strong></td>
          	    <td width="30" align="left" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
       	      </tr>
            <?php 
					for($i=count($tratamientos)-1 ; $i >= 0 ; $i--) {
						$tratamiento = $tratamientos[$i];
						if($tratamiento->fecha != null){
			?>          
            <tr>
          	      <td width="150" align="left" valign="top" bgcolor="#FFFFFF"><p>Fecha Indicacion: <?php echo $tratamiento->fecha ?></p></td>
          	      <td width="10" align="right" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
   	          <td align="left" valign="top" bgcolor="#FFFFFF"><?php echo $tratamiento->indicacion ?></td>
          	      <td width="30" align="left" valign="top" bgcolor="#FFFFFF"><a class="ver_controles" href="detalles_control.php?tratamientoid=<?php echo $i ?>&view=<?php echo $doc->_id ?>"><img src="images/icons/Report.png" width="32" height="32" border="0" /></a></td>
          	      <td align="left" valign="top" bgcolor="#FFFFFF"><a class="nuevo_control" href="agregar_control.php?tratamientoid=<?php echo $i ?>&view=<?php echo $doc->_id ?>"><img src="images/icons/Report-Add.png" width="32" height="32" border="0" /></a></td>
          	      <td width="30" align="left" valign="top" bgcolor="#FFFFFF"><input style="visibility:hidden;" class="Tratamientos_DeleteButton" type="button" name="deleteTratamientosButton_<?php echo $i ?>" id="deleteTratamientosButton_<?php echo $i ?>" value="" disabled="disabled" /></td>
       	        </tr>
            <?php 
						}else{
						}
					}
			?>
            </table>
          </div>
        </div>
      </div></td>
    </tr>
  </table>
  <p align="center">
</p>
<script type="text/javascript">
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("detalles_clinicos", {defaultTab:<?php echo $_GET["tab"] ?>});
var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("addConsulta", {contentIsOpen:false});
var CollapsiblePanel2 = new Spry.Widget.CollapsiblePanel("addInter_Consulta", {contentIsOpen:false});
var CollapsiblePanel3 = new Spry.Widget.CollapsiblePanel("addTratamiento", {contentIsOpen:false});
//-->
</script>
</body>
</html>