<?php
header("Content-Type: image/png");
error_reporting(E_ALL);
ini_set('display_errors', '1');

$min_x=-2;
$max_x=1;
$min_y=-1;
$max_y=1;
 
$dim_x=1024;
$dim_y=768;

$iter = 100;
 
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
