<?php
session_start();
$code = (string) random_int(1000, 9999);
$_SESSION['contact_captcha'] = $code;
header('Content-Type: image/png');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
if (!function_exists('imagecreatetruecolor')) {
    http_response_code(500);
    exit('PHP GD extension is required for CAPTCHA images.');
}
$image = imagecreatetruecolor(120, 48);
$background = imagecolorallocate($image, 255, 250, 241);
$text = imagecolorallocate($image, 35, 27, 18);
$noise = imagecolorallocate($image, 205, 174, 125);
imagefill($image, 0, 0, $background);
for ($i = 0; $i < 7; $i++) {
    imageline($image, random_int(0, 120), random_int(0, 48), random_int(0, 120), random_int(0, 48), $noise);
}
imagestring($image, 5, 25, 15, $code, $text);
imagepng($image);
imagedestroy($image);
