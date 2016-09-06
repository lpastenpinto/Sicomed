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
    <td width="1028" height="250" align="center" valign="middle" bgcolor="#FFFFFF"></td>
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
