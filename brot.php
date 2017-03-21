<?php
header("Content-Type: text/html");
error_reporting(E_ALL);
ini_set('display_errors', '1');

?><!DOCTYPE HTML>
<HTML lang="de">
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Mandelbrotmenge zoombar</title>
	<style>
	table, th, td {
		border: 0px;
		border-spacing: 0px;
		border-collapse: collapse;
		line-height: 0;
	}
	
	th, td {
		padding: 0px;
	}
	</style>

</HEAD>
<BODY>

<h1>Hier ist ein Ausschnitt der Mandelbrotmenge</h1>

<?php

$system = "Mainfrix";	// This will be an arry later
// Dimension of picture in pixel (always 4:3 ration for these mandelbrot pictures)
$dim_x=1024;
$dim_y=$dim_x / 4 * 3;

$center_x = (isset($_GET["x"]))? $_GET["x"] : -0.5;
$diameter_x = (isset($_GET["dx"]))? $_GET["dx"] : 1.5;
$center_y = (isset($_GET["y"]))? $_GET["y"] : 0.0;
$factor =  (isset($_GET["f"]))? $_GET["f"] : 1.0;
$iter =  (isset($_GET["i"]))? $_GET["i"] : 100;
$numWorkers = (isset($_GET["nw"]))? $_GET["nw"] : 4 * 3;
if ($numWorkers % 4 != 0 || $numWorkers % 3 != 0) {
	$numWorkers = (int)($numWorkers / 12);
	$numWorkers *= 12;
}

if (isset($_GET["dy"])) $diameter_y = $_GET["dy"];	// else do nothing. is set later on.
if (!isset($diameter_y)) $diameter_y = $diameter_x * 3 / 4;

$cs = $numWorkers / 3;
$rs = $numWorkers / $cs;
while ($cs / $rs > 4/3) {
	$cs /= 2;
	$rs = $numWorkers / $cs;
}

$cols = $cs;
$rows = $rs;
echo ("<p>NumWorkers = $numWorkers, Anzahl Rows = $rows und Anzahl Cols = $cols</p>\n");
?>
<div>
	<table border="0" padding="0">
		<?php
		$ymin = $center_y - $diameter_y;
		$ymax = $center_y + $diameter_y;
		$xmin = $center_x - $diameter_x;
		$xmax = $center_x + $diameter_x;
		
		for ($r = $rows - 1; $r >= 0; $r--) {
			$oben = $r * ($dim_y / $rows);
			$unten = ($r + 1) * ($dim_y / $rows) - 1;
			echo ("<tr>");
			for ($c = 0; $c < $cols; $c++) {
				$links = $c * ($dim_x / $cols);
				$rechts = ($c + 1) * ($dim_x / $cols) - 1;
				$str = "http://${system}/mandel.php?f=${factor}&x=${center_x}&y=${center_y}&dx=${diameter_x}&dy={$diameter_y}&i=${iter}"
						. "&pic_min_x=${links}&pic_max_x=${rechts}&pic_min_y=${oben}&pic_max_y=${unten}";
				echo ("<td> <img border=\"0\" src=\"${str}\"></img></td>\n");
			}
			echo ("</tr>\n");
		}
		
		?>
	</table>
</div>
</BODY>
</HTML>
