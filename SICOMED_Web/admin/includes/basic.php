<?php 
function paginar($filas_total,$mostrar,$page){
		echo '<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr><td>';
		$ruta = $_SERVER[SCRIPT_URI];
		$paginas=$filas_total/$mostrar;
		if($page==""){
		$page=1;
		}else{
		}
		echo 'Pagina: ';
			for($pagina=1;$pagina<=$paginas+1;$pagina++){
		echo '|<a href="'.$ruta.'?page='.$pagina.'">'.$pagina.'</a>| ';
		}
		$limite=$page*$mostrar;
		$inicio=$limite-$mostrar;
		echo '</tr></td></table>';
		/* Retorna:
			$inicio: para limitar la consulta SQL
			 -> Forma: mysql_db_query($db, "select * from tabla LIMIT ".$inicio.",".$mostrar.""); */
		return $inicio;
}