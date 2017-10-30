<?php
header("Content-Type: text/html");
error_reporting(E_ALL);
ini_set('display_errors', '1');
$debug = true;
$debug = false;
?>
<!DOCTYPE HTML>
<?php
$refresh = false;
if (isset($_GET["refresh"])) 
	if ($refresh = ($_GET["refresh"] == "y"))
		echo '<meta http-equiv="refresh" content="5" > ';
?>
<HTML lang="de">
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Mandelbrotmenge zoombar</title>
	<style>
	table, th, td {
		border: 0px;
		border-spacing: 0px;
		border-collapse: collapse;
		line-height: 0px;
	}
	
	th, td {
		padding: 0px;
	}
	</style>

</HEAD>
<BODY>

<script language="javascript" type="text/javascript">
    // if no search string (parameters) is given, 
    // forward to the same href with ist origin as parameter origURL
	if (document.location.search == "") {
		document.location.replace (document.location.href + "?origURL=" + document.location.origin);
	}
</script>

<h1>Hier ist ein Ausschnitt der Mandelbrotmenge</h1>
<?php

// $system = "http://frickler.eichler-web.de";	// Later this will be an array
// $system = "http://ebmandel.eu-central-1.elasticbeanstalk.com";
// $system = "http://localhost:8080";
// $system = "http://172.17.0.1:8080";	// Coding for docker service vIP

$system = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"];
echo "<p>Old link to system was $system ";
if ((strpos ($_SERVER["HTTP_HOST"], ":") === false) && (isset($_GET["origURL"]))) {
    $system = $_GET["origURL"];
    echo "and new link to system is $system";
}
echo "</p>";
// Dimension of picture in pixel (always 4:3 ration for these mandelbrot pictures)
$dim_x=1024;
$dim_y=$dim_x / 4 * 3;

$oldfac =  (isset($_GET["oldfac"]))? $_GET["oldfac"] : 1.0;
$factor =  (isset($_GET["f"]))? $_GET["f"] : 1.0;
if ($factor < 1.0) $factor = 1.0;

$center_x = (isset($_GET["x"]))? $_GET["x"] : -0.5;
$diameter_x = (isset($_GET["dx"]))? $_GET["dx"] : 1.5;
if ($oldfac != $factor) $diameter_x /= ($factor / $oldfac);

$center_y = (isset($_GET["y"]))? $_GET["y"] : 0.0;
if (isset($_GET["dy"])) $diameter_y = $_GET["dy"]; else $diameter_y = $diameter_x * 3 / 4;
if ($oldfac != $factor) $diameter_y /= ($factor / $oldfac);

$iter =  (isset($_GET["i"]))? $_GET["i"] : 100;
if ($iter < 3) $iter = 3;       // Otherwise we get trouble with color managent

$numWorkers = (isset($_GET["nw"]))? $_GET["nw"] : 192;

if ($numWorkers % 4 != 0 || $numWorkers % 3 != 0) {
	$numWorkers = (int)($numWorkers / 12);
	$numWorkers *= 12;
}

if ($numWorkers >= 12) {
	$cs = $numWorkers / 3;
	$rs = $numWorkers / $cs;
	while ($cs / $rs > 4/3) {
		$cs /= 2; 
		$rs = $numWorkers / $cs;
	}
} else {
	$cs = 1; 
	$rs = 1;
}

$cols = (int)$cs;
$rows = (int)$rs;
if ($debug) echo ("<p>NumWorkers = $numWorkers, Anzahl Rows = $rows und Anzahl Cols = $cols</p>\n");

if (isset($_GET["submit"])) {
	if ($debug) echo "<p>War Submittet</p>";
	if ($debug) print_r ($_GET);
	if ($diameter_x != 1.5) $diameter_y = $diameter_x;
	bekannteSeite ();
} else if (isset($_GET["reset"])) {
	if ($debug) echo "<p>War Reset</p>";
	$center_x = -0.5;
	$diameter_x = 1.5;
	$center_y = 0.0;
	$diameter_y = $diameter_x * 3 / 4;
	$factor = 1.0;
	$iter = 100;
	$numWorkers = 192; $cols = 16; $rows = 12;
	bekannteSeite ();
} else {
	if ($debug) echo "<p>War Neu</p>";
	if ($debug) print_r ($_GET);
	neueSeite ();
}

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
			$currentTime = time();

			for ($c = 0; $c < $cols; $c++) {
				$links = $c * ($dim_x / $cols);
				$rechts = ($c + 1) * ($dim_x / $cols) - 1;
				$factor = 1;
				$str = "${system}/mandel.php?f=${factor}&x=${center_x}&y=${center_y}&dx=${diameter_x}&dy={$diameter_y}&i=${iter}"
						. "&pic_min_x=${links}&pic_max_x=${rechts}&pic_min_y=${oben}&pic_max_y=${unten}&rnd=${currentTime}";

				// If user clicks to a link, which coordinates will be needed?
				$dx2 = $diameter_x / $cols;
				$dx2a = $dx2;// / 4 * 3;
				$dy2 = $diameter_y / $rows;
				$dy2a = $dy2;// / 3 * 4;
				
				$mx = ($center_x - $diameter_x) + ($diameter_x / $cols / 4 * 3) + (2 * $diameter_x / $cols * $c);
				$my = ($center_y - $diameter_y) + ($diameter_y / $rows / 3 * 4) + (2 * $diameter_y / $rows * $r);

				$link = "${system}/brot.php?f=${factor}&origURL=" . htmlspecialchars($system) 
					. "&x=${mx}&y=${my}&dx=${dx2a}&dy={$dy2a}&i=${iter}&refresh="
					. ($refresh? 'y':'n') . "&nw=$numWorkers&submit=Submit";
				echo ("<td> <a href=\"${link}\"><img border=\"0\" src=\"${str}\"></img></a></td>\n");
			}
			echo ("</tr>\n");
		}
		
		?>
	</table>
</div>

<?php
function neueSeite() {
	// $url = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]; 
	echo '	<form name="htmlform" method="get" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) .'">
            <input type="hidden" name="origURL" id="origURL" value="nothing">
			<table width="900px">
				<tr>
					<td valign="center">
						<label for="x">Center X</label>
					</td>
					<td valign="top">
						<input  type="text" name="x" maxlength="20" size="22" value="-0.5">
					</td>
					<td valign="center">
						<label for="dx">Diameter X</label>
					</td>
					<td valign="top">
						<input  type="text" name="dx" maxlength="20" size="22" value="1.5">
					</td>
				</tr>
				
				<tr>
					<td valign="center">
						<label for="y">Center Y</label>
					</td>
					<td valign="top">
						<input  type="text" name="y" maxlength="20" size="22" value="0">
					</td>
					<td valign="center">
						<label for="dy">Diameter Y</label>
					</td>
					<td valign="top">
						<input  type="text" name="dy" maxlength="20" size="22" value="1">
					</td>
				</tr>
		
				<tr>
					<td valign="center">
						<label for="i">Max iterations to black</label>
					</td>
					<td valign="center">
						<input  type="number" name="i" maxlength="20" size="22" value="100">
					</td>
					<td valign="center">
						<label for="nw"># worker procs</label>
					</td>
					<td valign="top">
						<input  type="number" name="nw" maxlength="20" size="22" value="192">
					</td>
				</tr>
				<tr>
					<td valign="center">
						<label for="i">&nbsp;</label>
					</td>
				</tr>
				<tr>
					<td colspan="4" style="text-align:center">
					<input type="checkbox" name="refresh" value="y" >Auto-Refresh
					</td>
					<td style="text-align:center">
					<input type="submit" name="submit" value="Submit" style="width:100px;">
					</td>
				</tr>
			</table>
		</form>
		<p></p>';
}

function bekannteSeite() {
	global $center_x, $diameter_x, $center_y, $diameter_y, $factor, $iter, $rows, $cols, $debug;
	if ($debug) echo "<p> $center_x, $diameter_x, $center_y, $diameter_y, $factor, $iter, $rows, $cols</p>p>";
	
	echo '	<form name="htmlform" method="get" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) .'">
            <input type="hidden" name="origURL" id="origURL" value="nothing">
			<table width="900px">
				<tr>
					<td valign="center">
						<label for="x">Center X</label>
					</td>
					<td valign="top">
						<input  type="text" name="x" maxlength="20" size="22" value="'. $center_x .'">
					</td>
					<td valign="center">
						<label for="dx">Diameter X</label>
					</td>
					<td valign="top">
						<input  type="text" name="dx" maxlength="20" size="22" value="'. $diameter_x .'">
					</td>
				</tr>
				
				<tr>
					<td valign="center">
						<label for="y">Center Y</label>
					</td>
					<td valign="top">
						<input  type="text" name="y" maxlength="20" size="22" value="'. $center_y .'">
					</td>
					<td valign="center">
						<label for="dy">Diameter Y</label>
					</td>
					<td valign="top">
						<input  type="text" name="dy" maxlength="20" size="22" value="'. $diameter_y .'">
					</td>
				</tr>
		
				<tr>
					<td valign="center">
						<label for="i">Max iterations to black</label>
					</td>
					<td valign="center">
						<input  type="number" name="i" maxlength="20" size="22" value="'. $iter .'">
					</td>
					<td valign="center">
						<label for="nw"># worker procs</label>
					</td>
					<td valign="top">
						<input  type="number" name="nw" maxlength="20" size="22" value="'. $rows * $cols .'">
					</td>
				</tr>
				<tr>
					<td valign="center">
						<p></p>
					</td>
				</tr>
				<tr>
					<td colspan="5" style="text-align:center">
					<input type="checkbox" name="refresh" value="y" ' 
						. ((isset($_GET["refresh"]) && ($_GET["refresh"] == "y"))? 'checked="checked" ' : '') . '>Auto-Refresh
					</td>
					<td style="text-align:center">
					<input type="submit" name="submit" value="Submit" tabindex="1" style="width:100px;">
					</td>
					<td style="text-align:center">
					<input type="submit" name="reset" value="Reset" tabindex="1" style="width:100px;">
					</td>

				</tr>
			</table>
		</form>
		<p></p>';

}

function einPaarSchoeneStellen() {
	$a[] = "/brot.php?x=-0.74303&dx=0.01611&y=0.126433&dy=0.016&f=1&i=4000&nw=192&foo=&oldfac=1&submit=Submit";
	$a[] = "/brot.php?x=-0.7435669&dx=0.0022878&y=0.1314023&dy=0.0022878&f=1&i=10000&nw=192&foo=&oldfac=1&submit=Submit";
	$a[] = "/brot.php?x=-0.5985&dx=0.0032958984375&y=0.664&dy=0.0032958984375&f=1&i=1000&nw=192&foo=&oldfac=1&submit=Submit";
	$a[] = "/brot.php?x=-0.60026267651841&dx=3.3946707844733E-7&y=0.66461459766865&dy=3.3946707844733E-7&f=1&i=50000&nw=192&foo=&oldfac=1&submit=Submit";
	
}
?>

<script language="javascript" type="text/javascript">
	// just remember the origin in a hidden argument
	// get the Protocol + Server + Port
    var orig = document.location.origin;
    document.getElementById("origURL").value = orig;
</script>


</BODY>
</HTML>
