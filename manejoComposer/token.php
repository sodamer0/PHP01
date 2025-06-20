
<?php
require 'vendor/autoload.php';

$client = new Google_Client();
$client->setClientId('128559852838-vg7r1b335h1gv9a2tfms0i4jc6c525u7.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/oauth2callback');
$client->addScope('https://mail.google.com/');
$client->setAccessType('offline'); // Importante: para obtener el refresh token
$client->setPrompt('select_account consent');

$authUrl = $client->createAuthUrl();


echo "1. Abre esta URL en tu navegador:\n$authUrl\n\n";
echo "2. Autoriza y pega aquí el código de verificación:\n> ";
$authCode = trim(fgets(STDIN));

// Intercambiar el código por el access_token y refresh_token
$accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

if (isset($accessToken['error'])) {
    echo "Error: " . $accessToken['error_description'];
    exit;
}

echo "\n✅ Access Token: " . $accessToken['access_token'];
echo "\n🔄 Refresh Token: " . $accessToken['refresh_token'];

