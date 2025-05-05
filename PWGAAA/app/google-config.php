<?php
require_once __DIR__ . '/../vendor/autoload.php';

$googleClient = new Google_Client();
$googleClient->setClientId('99199431351-4ecvr91uetsva21lvju4b3c0t2mpbrvv.apps.googleusercontent.com');
$googleClient->setClientSecret('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');
$googleClient->setRedirectUri('https://www.pwgaaa.xyz/google-callback');
$googleClient->addScope("email");
$googleClient->addScope("profile");
