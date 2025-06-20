
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;
require 'config.php';

$mail = new PHPMailer(true);
$provider = new Google([
    'clientId' => $_ENV['CLIENT_ID'],
    'clientSecret' => $_ENV['CLIENT_SECRET'],
]);

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->SMTPAuth = true;
$mail->AuthType = 'XOAUTH2';
$mail->setOAuth(new OAuth([
    'provider' => $provider,
    'clientId' => $_ENV['CLIENT_ID'],
    'clientSecret' => $_ENV['CLIENT_SECRET'],
    'refreshToken' => $_ENV['REFRESH_TOKEN'],
    'userName' => $_ENV['EMAIL'],
]));

$mail->setFrom($_ENV['EMAIL'], 'Nombre');
$mail->addAddress('6vmball@gmail.com');
$mail->Subject = 'Correo enviado con OAuth2';
$mail->Body = 'Este correo se ha enviado usando Gmail + OAuth2';

$mail->send();
echo "Correo enviado correctamente";



