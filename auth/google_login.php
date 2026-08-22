<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../vendor/autoload.php";

session_start();
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();
$client = new Google\Client();

$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri(
    "http://localhost/e_com_pj/auth/google_callback.php"
);

$client->addScope("email");
$client->addScope("profile");


$url = $client->createAuthUrl();

header("Location: ".$url);
exit;