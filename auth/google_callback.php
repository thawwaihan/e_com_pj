<?php

use Dotenv\Dotenv;

session_start();

require_once "../vendor/autoload.php";
require_once "../database/db.php";


$dotenv = Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();


$client = new Google\Client();

$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);

$client->setRedirectUri(
    "http://localhost/e_com_pj/auth/google_callback.php"
);


if(isset($_GET['code'])){


    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    $client->setAccessToken($token);


    $googleService = new Google\Service\Oauth2($client);

    $googleUser = $googleService->userinfo->get();


    $name = $googleUser->name;
    $email = $googleUser->email;
    $picture = $googleUser->picture;


    // Check database
    $check = $pdo->prepare(
        "SELECT * FROM users WHERE email = :email"
    );

    $check->execute([
        "email"=>$email
    ]);


    $user = $check->fetch(PDO::FETCH_ASSOC);



    // User does not exist
    if(!$user){

        $_SESSION['login_error'] = 
        "This Google account is not registered.";

        header("Location: login.php");
        exit;

    }



    // User exists create session

    $_SESSION['user'] = [
        "id"=>$user['id'],
        "name"=>$user['name'],
        "email"=>$user['email'],
        "picture"=>$user['profile_image']
    ];


    header("Location: ../pages/index.php");
    exit;

}
