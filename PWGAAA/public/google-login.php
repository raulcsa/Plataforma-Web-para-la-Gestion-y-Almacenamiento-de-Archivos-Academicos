<?php
require_once __DIR__ . '/../app/google-config.php';
header('Location: ' . $googleClient->createAuthUrl());
exit;
