<?php
include_once("config.php");

$tabla = false;
if (isset($_POST['buscar'])){
	$cui = mysqli_real_escape_string($mysqli, $_POST['cui']);
	$cuierr = "";
	if (empty($cui)){
		$cuierr = "* Ingrese un CUI";
		$tabla =  false;
	}else {
		$result = mysqli_query($mysqli, "SELECT * FROM students WHERE CUI=$cui");
		if (empty($result)){
			$cuierr = "* No regitrado";
		}else{
			$res = mysqli_fetch_array($result);
			if (empty($res)){
				$cuierr = "* Cui no encontrado";
			}else{
				$semestre = $res['Semestre'];
				$cursos = mysqli_query($mysqli, "SELECT * FROM curses WHERE Semestre=$semestre");
				$tabla = true;
			}	
		}
	}
}
 
?>
<html>
<head>	
	<title>Buscar Estudiantes</title>
	<link rel="stylesheet" href="styles.css"/>
</head>
<body>
	<form method="post" action="">
		<table id="buscador">
			<tr>
				<td>CUI</td>
				<td id="barra">
					<input type="text" name="cui" value="<?php echo $cui;?>">
					<span class="error"><?php echo $cuierr;?></span>
				</td>
				<td><input type="submit" value="Buscar" name="buscar"></td>
			</tr>
		</table>
		<?php
			if ($tabla == true){
				echo "<table><thead><tr>";
				echo "<td>Nombre</td><td>Semestre</td><td>Creditos</td>";
				echo "</tr></thead><tr>";
				echo "<td>".$res['Nombre']."</td>";
				echo "<td>".$res['Semestre']."</td>";
				echo "<td>".$res['Creditos_Accesibles']."</td>";
				echo "</tr></table>";
				echo "<table>";
				echo "<thead><tr><td>Id</td><td>Curso</td><td>Creditos</td><td>Pre_rrq_1</td><td>Pre_rrq_2</td><td>Semestre</td></tr></thead>";
				while($cur = mysqli_fetch_array($cursos)){
					echo "<tr>";
					echo "<td>".$cur['id']."</td>";
					echo "<td>".$cur['Nombre']."</td>";
					echo "<td>".$cur['Credits']."</td>";
					echo "<td>".$cur['Pre_rrq_1']."</td>";
					echo "<td>".$cur['Pre_rrq_2']."</td>";
					echo "<td>".$cur['Semestre']."</td>";
					echo "</tr>";
				}
				echo "</table>";
			}
		?>
</body>
</html>
