<?php
session_start();

header('Content-Type: image/png');

$imagen = imagecreatetruecolor(120, 30);
$colorFondo = imagecolorallocate($imagen, 255, 255, 255);
$colorTexto = imagecolorallocate($imagen, 0, 0, 0);

imagefill($imagen, 0, 0, $colorFondo);

$font = __DIR__ . '/arial.ttf';

$numero1 = rand(1, 9);
$numero2 = rand(1, 9);
$_SESSION['captchaResultadoCorrecto'] = $numero1 + $numero2;
$texto = "$numero1 + $numero2 =";

imagettftext($imagen, 20, 0, 10, 25, $colorTexto, $font, $texto);

imagepng($imagen);
imagedestroy($imagen);