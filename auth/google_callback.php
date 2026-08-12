<?php

session_start();

require_once "../vendor/autoload.php";
require_once "../database/db.php";


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
    $google_id = $googleUser->id;
    $picture = $googleUser->picture;

    $check = $pdo->prepare(
        "SELECT * FROM users WHERE email = :email"
    );

    $check->execute([
        "email"=>$email
    ]);

    $user = $check->fetch(PDO::FETCH_ASSOC);



    if(!$user){
        $sql = "
        INSERT INTO users
        (
            name,
            email,
            google_id,
            profile_imag e,
            password,
            role
        )
        VALUES
        (
            :name,
            :email,
            :google_id,
            :profile_image,
            NULL,
            'user'
        )
        ";


        $stmt = $pdo->prepare($sql);


        $stmt->execute([
            "name"=>$name,
            "email"=>$email,
            "google_id"=>$google_id,
            "profile_image"=>$picture
        ]);


        $user_id = $pdo->lastInsertId();


    }else{

        // Existing user
        $user_id = $user['id'];

    }

    // Create session
    $_SESSION['user'] = [
        "id"=>$user_id,
        "name"=>$name,
        "email"=>$email,
        "picture"=>$picture
    ];
    header("Location: ../pages/index.php");
    exit;

}