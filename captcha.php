<?php
// Lightweight SVG CAPTCHA: does not require the PHP GD extension.
session_start();

$code = (string) random_int(1000, 9999);
$_SESSION['contact_captcha'] = $code;

header('Content-Type: image/svg+xml; charset=UTF-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

$lines = '';
for ($i = 0; $i < 6; $i++) {
    $x1 = random_int(0, 120);
    $y1 = random_int(0, 48);
    $x2 = random_int(0, 120);
    $y2 = random_int(0, 48);
    $lines .= '<line x1="' . $x1 . '" y1="' . $y1 . '" x2="' . $x2 . '" y2="' . $y2 . '" stroke="#cdae7d" stroke-width="1"/>';
}

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<svg xmlns="http://www.w3.org/2000/svg" width="120" height="48" viewBox="0 0 120 48" role="img" aria-label="Four digit verification code">';
echo '<rect width="120" height="48" fill="#fffaf1"/>';
echo $lines;
echo '<text x="60" y="32" text-anchor="middle" font-family="Arial, sans-serif" font-size="23" font-weight="bold" letter-spacing="4" fill="#231b12">' . $code . '</text>';
echo '</svg>';
