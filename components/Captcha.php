<?php

session_start();

if(isset($_SESSION['captcha']))
{
    unset($_SESSION['captcha']);
}
$num_chars = 6;
$characters = array_merge(range(0, 9), range('A', 'Z'), range('a', 'z'));
shuffle($characters);


$captcha_text = "";
for($i = 0; $i < $num_chars; $i++) {
    $captcha_text .= $characters[rand(0, count($characters)-1)];
}

$_SESSION['captcha'] = $captcha_text;

header("Content-type: image/png");
$captcha_image = imagecreatetruecolor(140, 30);

$captcha_background = imagecolorallocate($captcha_image, 225, 238, 221);
$captcha_text_colour = imagecolorallocate($captcha_image, 58, 94, 47);

imagefilledrectangle($captcha_image, 0, 0, 140, 29, $captcha_background);

$font = '../assets/style/arial.ttf';

imagettftext($captcha_image, 20, 0, 11, 21, $captcha_text_colour, $font, $captcha_text);

echo imagepng($captcha_image);

imagedestroy($captcha_image);



