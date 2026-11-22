<?php
session_start();

function showMessage(string $title, string $message, bool $success = false): void {
    $colour = $success ? '#246b3d' : '#9b2c2c';
    echo '<!doctype html><html lang="en"><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</title><body style="margin:0;background:#fffaf1;color:#17130f;font:16px Arial,sans-serif;display:grid;min-height:100vh;place-items:center"><main style="max-width:560px;margin:24px;padding:32px;background:white;border:1px solid #eadfce;border-radius:6px"><h1 style="color:' . $colour . '">' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</h1><p>' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . '</p><a href="index.html#visit" style="display:inline-block;margin-top:12px;padding:12px 18px;background:#f4a62a;color:#21170c;text-decoration:none;font-weight:bold">Back to website</a></main></body></html>';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.html#visit');
    exit;
}
if (!empty($_POST['website'])) {
    showMessage('Message not sent', 'Please return to the contact form and try again.');
}

$name = trim((string)($_POST['name'] ?? ''));
$email = trim((string)($_POST['email'] ?? ''));
$phone = trim((string)($_POST['phone'] ?? ''));
$message = trim((string)($_POST['message'] ?? ''));
$captcha = trim((string)($_POST['captcha'] ?? ''));
$expected = (string)($_SESSION['contact_captcha'] ?? '');
unset($_SESSION['contact_captcha']);

if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $message === '') {
    showMessage('Please check your details', 'Enter your name, a valid email address and a message.');
}
if ($expected === '' || !preg_match('/^\d{4}$/', $captcha) || !hash_equals($expected, $captcha)) {
    showMessage('CAPTCHA did not match', 'Please return to the form, refresh the page and try again.');
}

// Change this to the restaurant's preferred receiving email if needed.
$recipient = 'hello@mjafricancuisine.com';
$subject = 'Website enquiry - M.J African Cuisine';
$body = "Name: {$name}\nEmail: {$email}\nPhone: {$phone}\n\nMessage:\n{$message}";
$headers = "From: website@mjafricancuisine.com\r\n";
$headers .= "Reply-To: {$email}\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

if (!mail($recipient, $subject, $body, $headers)) {
    showMessage('Unable to send message', 'The server could not send your enquiry. Please contact us by email instead.');
}
showMessage('Thank you!', 'Your message has been sent successfully. We will be in touch soon.', true);
