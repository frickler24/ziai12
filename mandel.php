<?php
header("Content-Type: image/png");
error_reporting(E_ALL);
ini_set('display_errors', '1');

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
	// echo "$c\n";
	if ($c <= 1) imagesetpixel			($im, $x - $pic_min_x, $pic_max_y - $y,
		createcolor ($im, (int)(255*$c), 0, 0));
	else if ($c <= 2) imagesetpixel	($im, $x - $pic_min_x, $pic_max_y - $y,
		createcolor ($im, 255, (int)(255*($c-1.0)), 0));
	else imagesetpixel				($im, $x - $pic_min_x, $pic_max_y - $y,
		createcolor ($im, 255, 255, (int)(255*($c-2.0))));
}

function colorSchema3 ($i) {
	global $iter, $im, $x, $pic_min_x, $pic_max_x, $y, $pic_min_y, $pic_max_y;
	$c = (3 * log ($i) / log ($iter - 1.0));
	// echo "$c\n";
	if ($c < 1) imagesetpixel			($im, $x - $pic_min_x, $pic_max_y - $y,
		createcolor ($im, (int)(255*$c), 255, 255));
	else if ($c < 2) imagesetpixel	($im, $x - $pic_min_x, $pic_max_y - $y,
		createcolor ($im, 255, (int)(255*($c-1.0)), 255));
	else imagesetpixel				($im, $x - $pic_min_x, $pic_max_y - $y,
		createcolor ($im, 255, 255, (int)(255*($c-2.0))));
}

function colorSchema2 ($i) {
	global $iter, $im, $x, $pic_min_x, $pic_max_x, $y, $pic_min_y, $pic_max_y;
	$c = $i;// % (1<<23);
	imagesetpixel ($im, $x - $pic_min_x, $pic_max_y - $y, createcolor ($im, ($c>>16) & 0xff, ($c>>8) & 0xff, $c & 0xff));
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
		colorSchema1 ($i);
	}
  }
}
 
imagepng($im);
imagedestroy($im);
?>
