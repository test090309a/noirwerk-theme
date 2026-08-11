<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

$to = 'test@example.com';
$subject = 'Test E-Mail';
$message = 'Das ist ein Test.';
$headers = array('Content-Type: text/plain; charset=UTF-8');

$sent = wp_mail($to, $subject, $message, $headers);

echo 'Test-Mail gesendet: ' . ($sent ? 'JA ✅' : 'NEIN ❌');
?>
