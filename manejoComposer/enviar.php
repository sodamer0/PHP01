<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = 'formadixital.com';// Cambia por tu servidor SMTP
$mail->SMTPAuth = true;
$mail->Username = 'alumno@formadixital.com';
$mail->Password = 'Aspasia_AFD25';
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;
$mail->SMTPOptions = [
    'ssl' => [
        'verify_peer'       => false,
        'verify_peer_name'  => false,
        'allow_self_signed' => true,
    ],
];
$mail->setFrom('alumno@formadixital.com', 'Carlos');
$mail->addAddress('sapecarr@afd.novadixital.es', 'Destino');
$mail->Subject = 'Hola desde PHPMailer con Composer';
$mail->Body    = 'Este es un mensaje de prueba enviado con Composer y PHPMailer';

if ($mail->send()) {
    echo "Mensaje enviado correctamente.";
} else {
    echo "Error al enviar: " . $mail->ErrorInfo;
}