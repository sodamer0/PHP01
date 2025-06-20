<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use League\OAuth2\Client\Provider\Google;

require 'vendor/autoload.php';

// Datos de Google Cloud
$clientId = '128559852838-vg7r1b335h1gv9a2tfms0i4jc6c525u7.apps.googleusercontent.com';
$clientSecret = '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';
$refreshToken = '1//03Hf-VEj5jLBcCgYIARAAGAMSNwF-L9Ir82jwUhIo9meUi6o3fWikneMQhkjP1jhLudF_ZxdzcIXhkJ_tE6G45btigboa_u8g7Uo'; // Se obtiene una vez (ver más abajo)
$email = 'sapecarr@afd.novadixital.es';

$provider = new Google([
    'clientId'     => $clientId,
    'clientSecret' => $clientSecret,
]);

$mail = new PHPMailer(true);

try {
    // Configuración básica
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->Port       = 587;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->SMTPAuth   = true;

    // Configuración OAuth2
    $mail->AuthType = 'XOAUTH2';
    $mail->setOAuth(new \PHPMailer\PHPMailer\OAuth([
        'provider'       => $provider,
        'clientId'       => $clientId,
        'clientSecret'   => $clientSecret,
        'refreshToken'   => $refreshToken,
        'userName'       => $email,
    ]));

    $mail->setFrom($email, 'Santi');
    $mail->addAddress('carlos@novadixital.es');
    $mail->Subject = 'Correo con OAuth2';
    $mail->Body    = 'Este correo fue enviado usando Gmail + OAuth2.';
    $mail->send();
    echo 'Correo enviado correctamente';
} catch (Exception $e) {
    echo "Error al enviar: {$mail->ErrorInfo}";
}

