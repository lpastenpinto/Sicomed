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
<title>Gestion Sicomed</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-image: url(images/bg.JPG);
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
			new vlaDatePicker('exampleIII',  { openWith: 'togglePicker', offset: { y: -2, x: 2 }, separateInput: { day: 'day', month: 'month', year: 'year' }, alignX: 'center', alignY: 'bottom', offset: { y: 3 }, filePath: 'jscripts/vlacal/inc/' });
        });
</script>

<script src="jscripts/jquery-1.6.4.js" type="text/javascript"></script>   
<script type="text/javascript" src="jscripts/jquery.form.js"></script>

<script type="text/javascript" src="jscripts/jquery.Rut.js"></script>

<script type="text/javascript" src="jscripts/jquery.validate.js"></script>

<script type="text/javascript"> 
		jQuery.noConflict();

        jQuery(document).ready(function() {
			var opciones= {
							beforeSerialize: editaRut,
                			beforeSubmit: validate, //funcion que se ejecuta antes de enviar el form
                            success: mostrarRespuesta, //funcion que se ejecuta una vez enviado el formulario
							resetForm: true,
							   
            };
	
             //asignamos el plugin ajaxForm al formulario myForm y le pasamos las opciones
            jQuery('#addPaciente').ajaxForm(opciones) ; 
            
             //lugar donde defino las funciones que utilizo dentro de "opciones"
			 function editaRut(){
				 		var rut = jQuery.Rut.quitarFormato(jQuery("#rut").val());
						jQuery("#rut").val(rut);
			 };
			 
             function validate(formData, jqForm, options) { 			 		
                      	jQuery("#loader_gif").fadeIn("slow");
						if(jQuery("#addPaciente").valid() == false){
							jQuery("#loader_gif").fadeOut("slow");
							return false;
						}
             };
             function mostrarRespuesta (responseText){
				          alert("Paciente Ingresado Exitosamente");
                          jQuery("#loader_gif").fadeOut("slow");
						  jQuery('#addPaciente').reset();
						  //window.location.replace("personal.php");
             };
			 
			 jQuery('#rut').Rut({
				validation: 'true',
  				//format: 'false',
  				digito_verificador: '#dv',
				on_error: function(){
					alert('El rut ingresado es incorrecto');
					jQuery('#rut').val('');
					jQuery('#dv').val('');
				}
			});
			 			
        }); 
</script> 

</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="80" colspan="2" align="center" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="20%">&nbsp;</td>
          <td align="center" width="60%"><img src="images/logoweb.png" width="350" height="141" /></td>
          <td align="right" valign="bottom" width="20%">
		  <?php 
  include("includes/reloj.html");
  				$hoy = getdate();
				$mes = $hoy["mon"];
				$ano = $hoy["year"];
				$dia = $hoy["mday"];
  echo ''.$dia.'/'.$mes.'/'.$ano.'';
  ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td height="15" colspan="2" align="center" valign="top" bgcolor="#EEEEEE"><div align="right">
     
    </div></td>
  </tr>
  <tr>
    <td width="205" height="250" align="center" valign="top" bgcolor="#FFFFFF">
    <?php 
	if($_SESSION["level"] > 1){
		include("menu_admin.htm");
	}else{
		include("menu_user.htm");
	}
	?>
    </td>
    <td width="1028" height="250" align="center" valign="top" bgcolor="#FFFFFF">
<p>
<form id="addPaciente" action="includes/agrega_paciente.php" method="post">
<table width="945" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="2" align="center"><strong>Agregando Nuevo Paciente</strong></td>
  </tr>
  <tr>
    <td width="458" align="center" valign="top"><table width="438" border="0" cellpadding="2" cellspacing="2" >
      <tr>
        <td align="center"><strong>Antecedentes personales</strong></td>
      </tr>
      <tr>
        <td align="right">R.U.N. :
          <input name="rut" type="text"  id="rut" size="9" maxlength="10" class="required"/>
          -
          <label>
            <input name="dv" type="text" id="dv" size="2" maxlength="1" class="required"/>
          </label></td>
      </tr>
      <tr>
        <td align="right">Nombres :
          <input name="nombre" type="text"  id="nombre" class="required"/></td>
      </tr>
      <tr>
        <td align="right">Apellido Paterno:
          <input name="apellido_paterno" type="text"  id="apellido_paterno" class="required"/></td>
      </tr>
      <tr>
        <td align="right">Apellido Materno:
          <input name="apellido_materno" type="text"  id="apellido_materno" class="required"/></td>
      </tr>
      <tr>
        <td align="right">Fecha de Nacimiento:
          <span id="exampleIII">
					<input name="day" type="text" style="width: 18px; border-width: 1px 0 1px 1px;" maxlength="2" /><input value="/" type="text" style="width: 5px; border-width: 1px 0 1px 0;" disabled="disabled" /><input name="month" class="textbox" type="text" style="width: 16px; border-width: 1px 0 1px 0;" maxlength="2" /><input value="/" type="text" style="width: 5px; border-width: 1px 0 1px 0;" disabled="disabled" /><input name="year" type="text" style="width: 28px; border-width: 1px 0 1px 0;" maxlength="4" /><input type="text" style="width: 15px; border-width: 1px 1px 1px 0;" disabled="disabled" /><img src="jscripts/vlacal/images/calendar.gif" id="togglePicker" class="pickerImg" width="13" height="12" alt="" />
				</span></td>
      </tr>
      <tr>
        <td align="right">Sexo:
          <label>
            <select name="sexo" id="sexo">
              <option value="M" selected="selected">Masculino</option>
              <option value="F">Femenimo</option>
              </select>
            </label></td>
      </tr>
      <tr>
        <td align="right">Domicilio:
          <input name="domicilio" type="text"  id="domicilio" class="required"/></td>
      </tr>
      <tr>
        <td align="right">Telefono:
          <input name="telefono" type="text"  id="telefono" class="required number"/></td>
      </tr>
      <tr>
        <td align="right">Actividad: 
          <label>
            <select name="actividad" id="actividad">
              <option value="Estudiante">Estudiante</option>
              <option value="Trabajador Dependiente">Trabajador Dependiente</option>
              <option value="Trabajador Independiente">Trabajador Independiente</option>
              <option value="Jubilado">Jubilado</option>
              <option value="Desempleado">Desempleado</option>
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
            <option value="A">Grupo A</option>
            <option value="B">Grupo B</option>
            <option value="AB">Grupo AB</option>
            <option value="0">Grupo 0</option>
          </select></td>
      </tr>
      <tr>
        <td align="right">Estatura:
          <input name="estatura" type="text"  id="estatura" class="required"/></td>
      </tr>
      <tr>
        <td align="right">Peso:
          <input name="peso" type="text"  id="peso" class="required"/></td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
      </tr>
      <tr>
        <td align="right"><label>
          <input type="submit" name="SendButton" id="SendButton" value="Guardar" /><img id="loader_gif" src="images/loader.gif" style=" display:none;"/>
          </label></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</p>
    </td>
  </tr>
</table>
<br />
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td><div align="center">
      <p>&copy; 2012 Sicomed<br />
It's True Services - Web Development </p>
</div></td>
  </tr>
</table>
</body>
</html>
