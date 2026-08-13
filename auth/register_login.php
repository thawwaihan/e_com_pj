<?php
session_start();

require_once "../database/db.php";

if(isset($_POST['register'])){

    $name = $_POST['name'];
    $email = $_POST['email'];

    $password = password_hash(
        $_POST['password'],
        PASSWORD_DEFAULT
    );


    $check = $pdo->prepare(
        "SELECT * FROM users WHERE email=:email"
    );

    $check->execute([
        "email"=>$email
    ]);


    if($check->rowCount()>0){
        $_SESSION['error']="Email already exists";
        header("Location: login.php?register");
        exit;
    }



    $stmt=$pdo->prepare("
        INSERT INTO users
        (
        name,
        email,
        password,
        role
        )
        VALUES
        (
        :name,
        :email,
        :password,
        'user'
        )
    ");


    $stmt->execute([
        "name"=>$name,
        "email"=>$email,
        "password"=>$password
    ]);


    $_SESSION['success']="Register successful";

    header("Location: ../pages/index.php");

}

?>