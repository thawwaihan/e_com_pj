<?php
session_start();
require_once "../database/db.php";

if(isset($_POST['register'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // check email
    $check = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $check->execute([
        "email"=>$email
    ]);

    if($check->rowCount() > 0){
        $error = "Email already exists";
    }else{

        $sql = "
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
        ";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            "name"=>$name,
            "email"=>$email,
            "password"=>$password
        ]);

        $_SESSION['success'] = "Register successful";
        header("Location: login.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>

<body>

<h2>Register</h2>

<?php if(isset($error)): ?>
<p><?= $error ?></p>
<?php endif; ?>


<form method="POST">

    <label>Name</label>
    <input type="text" name="name" required>

    <br>

    <label>Email</label>
    <input type="email" name="email" required>

    <br>

    <label>Password</label>
    <input type="password" name="password" required>

    <br>

    <button type="submit" name="register">
        Register
    </button>

</form>

</body>
</html>