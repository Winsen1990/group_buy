<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2016/11/27
 * Time: 下午7:09
 */
header ('Content-Type: image/png');
$font_size = 64;
$height = intval($_GET['h']);
$width = intval($_GET['w']);
$no_image = imagecreatetruecolor($width, $height);
$bg_color = imagecolorallocate($no_image, 224, 224, 224);
imagefill($no_image, 0, 0, $bg_color);
$font_color = imagecolorallocate($no_image, 170, 170, 170);
$text = $width.'x'.$height;
$x = 0;
$y = 0;

do {
    $font_width = strlen($text) * $font_size * 0.85;
    $font_height = $font_size*1.4;
    $x = ($width - $font_width)/2;
    $y = ($height + $font_height * 0.7)/2;
} while(($x < 0 || $height < $y) && $font_size--);

imagefttext($no_image, $font_size, 0, $x, $y, $font_color, '../library/font/Mono.ttf', $text);
imagepng($no_image);
imagedestroy($no_image);
?>