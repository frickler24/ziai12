<?php
header("Content-Type: text/html");
error_reporting(E_ALL);
ini_set('display_errors', '1');

?><!DOCTYPE HTML>
<HTML lang="de">
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Mandelbrotmenge zoombar</title>
</HEAD>
<BODY>

<h1>Hier ist ein Ausschnitt der Mandelbrotmenge</h1>

<?php

// echo "<pre>"; print_r ($_SERVER); echo "</pre>";
// echo "<p></p>";
echo "<pre>"; print_r ($_GET); echo "</pre>";

$center_x = (isset($_GET["x"]))? $_GET["x"] : -0.5;
$diameter_x = (isset($_GET["dx"]))? $_GET["dx"] : 1.5;
$center_y = (isset($_GET["y"]))? $_GET["y"] : 0.0;
$factor =  (isset($_GET["f"]))? $_GET["f"] : 1.0;
$iter =  (isset($_GET["i"]))? $_GET["i"] : 100;

if (isset($_GET["dy"])) $diameter_y = $_GET["dy"];	// else do nothing. is set later on.

$min_x = $center_x - $diameter_x;
$max_x = $center_x + $diameter_x;

if (!isset($diameter_y)) $diameter_y = $diameter_x * 3 / 4;
$min_y = $center_y - $diameter_y;
$max_y = $center_y + $diameter_y;
 
$iter = $iter * $factor;
 
$dim_x=1024;
$dim_y=768;

$im = imageCreateTrueColor ($dim_x, $dim_y)
  or die("Cannot Initialize new GD image stream");
$black_color = imagecolorallocate($im, 0, 0, 0);
$white_color = imagecolorallocate($im, 255, 255, 255);

for($y=0;$y<=$dim_y;$y++) {
  for($x=0;$x<=$dim_x;$x++) {
    $c1=$min_x+($max_x-$min_x)/$dim_x*$x;
    $c2=$min_y+($max_y-$min_y)/$dim_y*$y;
 
    $z1=0;
    $z2=0;
 
    for ($i=0; $i < $iter; $i++) {
      $new1=$z1*$z1-$z2*$z2+$c1;
      $new2=2*$z1*$z2+$c2;
      $z1=$new1;
      $z2=$new2;
      if($z1*$z1+$z2*$z2>=4) {
        break;
      }
    }
    if ($i < $iter) {
	  $c = (1 * log ($i) / log ($iter - 1.0));
	  // echo "$c\n";
	  if ($c < 1) imagesetpixel ($im, $x, $y, imageColorAllocate ($im, (int)(255*$c), 0, 0));
	  else if ($c < 2) imagesetpixel ($im, $x, $y, imageColorAllocate ($im, 255, (int)(255*$c-1.0), 0));
	  else imagesetpixel ($im, $x, $y, imageColorAllocate ($im, 255, 255, (int)(255*$c-2.0)));
	}
  }
}
 
imagepng($im);
imagedestroy($im);
?>
</BODY>
</HTML>
