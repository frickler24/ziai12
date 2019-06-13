<?php
header("Content-Type: image/png");
error_reporting(E_ALL);
ini_set('display_errors', '1');

$paintACircle = FALSE;
$paintACircle = TRUE;

// Dimension of picture in pixel (always 4:3 ration for these mandelbrot pictures)
$dim_x=1024;
$dim_y=$dim_x / 4 * 3;

$center_x = (isset($_GET["x"]))? $_GET["x"] : -0.5;
$diameter_x = (isset($_GET["dx"]))? $_GET["dx"] : 1.5;
$center_y = (isset($_GET["y"]))? $_GET["y"] : 0.0;
$factor =  (isset($_GET["f"]))? $_GET["f"] : 1.0;
$iter =  (isset($_GET["i"]))? $_GET["i"] : 100;
$pic_min_x = (isset($_GET["pic_min_x"]))? $_GET["pic_min_x"] : 0;
$pic_max_x = (isset($_GET["pic_max_x"]))? $_GET["pic_max_x"] : $dim_x;
$pic_min_y = (isset($_GET["pic_min_y"]))? $_GET["pic_min_y"] : 0;
$pic_max_y = (isset($_GET["pic_max_y"]))? $_GET["pic_max_y"] : $dim_y;
if (isset($_GET["dy"])) $diameter_y = $_GET["dy"];	// else do nothing. is set later on.

$min_x = $center_x - $diameter_x;
$max_x = $center_x + $diameter_x;

if (!isset($diameter_y)) $diameter_y = $diameter_x * 3 / 4;
$min_y = $center_y - $diameter_y;
$max_y = $center_y + $diameter_y;

$iter = $iter * $factor;

// echo "<p>min_x = $min_x, max_x = $max_x, min_y = $min_y, max_y = $max_y, dia_x = $diameter_x, dia_y = $diameter_y, iter = $iter, factor = $factor</p>";
// echo "<p>startc1(1) = " . $min_x+($max_x-$min_x)/$dim_x . ", startc2(1) = " . $c2=$min_y+($max_y-$min_y)/$dim_y . "</p>\n";

// Only 255 colors may be defined max.
// Redefinition of existing color leads to new color value.
// This function handles both.
function createcolor($pic,$c1,$c2,$c3) {
	//get color from palette
	$color = imagecolorexact($pic, $c1, $c2, $c3);
	if($color==-1) {
		//color does not exist...
		//test if we have used up palette
		if(imagecolorstotal($pic)>=255) {
			//palette used up; pick closest assigned color
			$color = imagecolorclosest($pic, $c1, $c2, $c3);
		} else {
			//palette NOT used up; assign new color
			$color = imagecolorallocate($pic, $c1, $c2, $c3);
		}
	}
	return $color;
}

function colorSchema1 ($i) {
	global $iter, $im, $x, $pic_min_x, $pic_max_x, $y, $pic_min_y, $pic_max_y;
	$c = (3 * log ($i) / log ($iter - 1.0));

	if ($c <= 1) imagesetpixel			($im, $x - $pic_min_x, $pic_max_y - $y,
		createcolor ($im, (int)(255*$c), 0, 0));
	else if ($c <= 2) imagesetpixel	($im, $x - $pic_min_x, $pic_max_y - $y,
		createcolor ($im, 255, (int)(255*($c-1.0)), 0));
	else imagesetpixel				($im, $x - $pic_min_x, $pic_max_y - $y,
		createcolor ($im, 255, 255, (int)(255*($c-2.0))));
}

function colorSchema3 ($i) {
	global $iter, $im, $x, $pic_min_x, $pic_max_x, $y, $pic_min_y, $pic_max_y, $fp;
	$c = (5 * log ($i) / log ($iter - 1.0));
	
	if ($c < 0) $c = 0.0;
	if ($c > 5) $c = 5.0;
	
	if ($c <= 1) imagesetpixel ($im, $x - $pic_min_x, $pic_max_y - $y, 		createcolor ($im, (int)(255*$c), 0, 0));
	else if ($c <= 2) imagesetpixel	($im, $x - $pic_min_x, $pic_max_y - $y, createcolor ($im, 255, (int)(255*($c-1.0)), 0));
	else if ($c <= 3) imagesetpixel	($im, $x - $pic_min_x, $pic_max_y - $y, createcolor ($im, 255, 255, (int)(255*($c-2.001))));
	else if ($c <= 4) imagesetpixel	($im, $x - $pic_min_x, $pic_max_y - $y, createcolor ($im, 255, (int)(255*(4.0 - $c)), 255));
	else 			  imagesetpixel	($im, $x - $pic_min_x, $pic_max_y - $y, createcolor ($im, (int)(255*($c - 4.0)), 255, 255));
}

$im = imageCreateTrueColor ($pic_max_x - $pic_min_x, $pic_max_y - $pic_min_y)
  or die("Cannot Initialize new GD image stream with $pic_max_x - $pic_min_x, $pic_max_y - $pic_min_y");
$black_color = imagecolorallocate($im, 0, 0, 0);
$white_color = imagecolorallocate($im, 255, 255, 255);

for ($y = $pic_min_y; $y <= $pic_max_y; $y++) {
  for ($x = $pic_min_x; $x <= $pic_max_x; $x++) {
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
		colorSchema3 ($i);
	}
  }
}


if ($paintACircle) {
	$red = 0;
	$green = 0;
	$blue = 0;
	$host = gethostname();	// in docker, hostnames are hex numbers in text form

	switch ($host[0]) {
	case "a":
	case "g":
	case "k":
	case "p":
	case "e":
	case "0":
	case "1":
		$green = 255;
	break;
	case "b":
	case "f":
	case "h":
	case "i":
	case "j":
	case "2":
	case "3":
		$blue = 255;
	break;
	case "c":
	case "l":
	case "m":
	case "n":
	case "o":
	case "4":
	case "5":
		$red = 255;
	break;
	case "d":
	case "q":
	case "r":
	case "s":
	case "t":
	case "6":
	case "7":
		$green = rand (0, 255);
		$red   = rand (0, 255);
		$blue  = rand (0, 255);
	break;
	default:
	break;
	}

	// determine center and width of circle to draw
	$myCenterX = ($pic_max_x - $pic_min_x)/2;
	$myCenterY = ($pic_max_y - $pic_min_y)/2;
	$myWidth = min ($pic_max_x - $pic_min_x, $pic_max_y - $pic_min_y) / 4;

	$circleColor = createcolor ($im, $red, $green, $blue);
	imagefilledellipse ($im, $myCenterX, $myCenterY, $myWidth, $myWidth, $circleColor);
}
imagepng($im);
imagedestroy($im);
?>
