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

if (!isset($_GET['code'])) {
    $_SESSION['login_error'] = "Google login failed.";
    header("Location: login.php");
    exit;
}

$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

/*
|--------------------------------------------------------------------------
| Check token response
|--------------------------------------------------------------------------
*/

if (isset($token['error'])) {

    echo "<pre>";
    print_r($token);
    echo "</pre>";

    exit;
}

if (!isset($token['access_token'])) {

    echo "Access token was not returned.";

    exit;
}

$client->setAccessToken($token);

/*
|--------------------------------------------------------------------------
| Get Google User
|--------------------------------------------------------------------------
*/

$googleService = new Google\Service\Oauth2($client);
$googleUser = $googleService->userinfo->get();

$googleId = $googleUser->id;
$name     = $googleUser->name;
$email    = $googleUser->email;
$picture  = $googleUser->picture;


/*
|--------------------------------------------------------------------------
| Check User
|--------------------------------------------------------------------------
*/

$check = $pdo->prepare(
    "SELECT * FROM users 
     WHERE email = :email 
     LIMIT 1"
);

$check->execute([
    "email" => $email
]);

$user = $check->fetch(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| User does not exist
|--------------------------------------------------------------------------
*/

if (!$user) {

    $_SESSION['login_error'] =
        "This Google account is not registered.";

    header("Location: login.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| Save Google information
|--------------------------------------------------------------------------
*/

$update = $pdo->prepare(
    "UPDATE users
     SET google_id = :google_id,
         profile_image = :profile_image
     WHERE id = :id"
);

$update->execute([
    "google_id"     => $googleId,
    "profile_image" => $picture,
    "id"            => $user['id']
]);


/*
|--------------------------------------------------------------------------
| Create Session
|--------------------------------------------------------------------------
*/

$_SESSION['user'] = [
    "id"      => $user['id'],
    "name"    => $user['name'],
    "email"   => $user['email'],
    "picture" => $picture
];

header("Location: ../pages/index.php");
exit;