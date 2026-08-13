<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Everyday | Account</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        body {

            height: 100vh;

            display: flex;

            justify-content: center;

            align-items: center;

            font-family: Arial, sans-serif;

            background: #f5f1eb;

        }



        /* Main Container */

        .container {

            width: 850px;

            height: 520px;

            background: white;

            border-radius: 25px;

            overflow: hidden;

            position: relative;

            box-shadow: 0 20px 50px rgba(0, 0, 0, .15);

        }

        /* Forms */

        .form-container {

            position: absolute;

            top: 0;

            height: 100%;

            width: 50%;

            display: flex;

            justify-content: center;

            align-items: center;

            flex-direction: column;

            padding: 50px;

            transition: .6s ease-in-out;

        }

        .login {
            left: 0;
            z-index: 2;
        }


        .signup {
            left: 0;
            opacity: 0;
            z-index: 1;
        }


        /* When Register is active */

        .container.active .login {

            transform: translateX(100%);

            opacity: 0;

        }


        .container.active .signup {

            transform: translateX(100%);

            opacity: 1;

            z-index: 5;

        }

        .form-container {
            transition:
                transform .6s ease-in-out,
                opacity .3s ease-in-out;
        }

        h1 {

            margin-bottom: 20px;

            letter-spacing: 2px;

        }

        input {

            width: 100%;

            padding: 14px;

            margin: 8px 0;

            border-radius: 12px;

            border: 1px solid #ddd;

            outline: none;

        }

        input:focus {

            border-color: #111;

        }

        button {

            width: 100%;

            padding: 14px;

            border-radius: 12px;

            border: none;

            cursor: pointer;

            font-weight: bold;

            margin-top: 15px;

        }



        .main-btn {

            background: #111;

            color: white;

        }

        .main-btn:hover {

            background: #333;

        }
        .google {

            background: white;

            border: 1px solid #ddd;

        }

        .google:hover {

            background: #f7f7f7;

        }

        .google i {

            color: #4285F4;

            margin-right: 10px;

        }

        /* Switch Panel */
        .switch-container {

            position: absolute;

            right: 0;

            width: 50%;

            height: 100%;

            background: #111;

            color: white;

            display: flex;

            justify-content: center;

            align-items: center;

            text-align: center;

            transition: .6s;

        }

        .container.active .switch-container {

            transform: translateX(-100%);

        }

        .switch {

            padding: 40px;

        }

        .switch h1 {

            font-size: 35px;

        }

        .switch p {

            color: #ddd;

            margin-bottom: 25px;

        }

        .switch button {

            background: white;

            color: #111;

        }

        .switch button:hover {

            background: #eee;

        }

        .brand {

            font-size: 30px;

            letter-spacing: 5px;

            font-weight: bold;

            margin-bottom: 10px;

        }

        .small {

            color: #777;

            margin-bottom: 20px;

        }

        a {

            text-decoration: none;

        }
        .alert {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 350px;
            padding: 12px;
            border-radius: 10px;
            text-align: center;
            z-index: 10;
            transition: opacity 0.5s ease;
        }

        .alert.hide {
        opacity: 0;
        pointer-events: none;
        }

        .alert-danger {
            background: #ffe5e5;
            color: #c00;
            border: 1px solid #ffb3b3;
        }
        .password-wrapper {
    position: relative;
    width: 100%;
}

.password-wrapper input {
    padding-right: 45px;
}

.password-toggle {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #777;
    font-size: 16px;
}

.password-toggle:hover {
    color: #111;
}
    </style>

</head>
<body>

    <div class="container" id="container">


        <?php
        if (isset($_SESSION['login_error']) || isset($_SESSION['error'])){
        ?>
            <div class="alert alert-danger" id="alertMessage">
                 <?= htmlspecialchars($_SESSION['login_error'] ?? $_SESSION['error']); ?>
            </div>
        <?php
           unset($_SESSION['login_error'], $_SESSION['error']);
        }
        ?>
        

        <div class="form-container login">


            <h1>Login</h1>

            <div class="brand">
                EVERYDAY
            </div>


            <p class="small">
                Welcome back to your style
            </p>

            <form action="login_process.php" method="POST">
                <input
                    type="email"
                    name="email"
                    placeholder="Email Address"
                    required>

                <div class="password-wrapper">
    <input
        type="password"
        name="password"
        id="loginPassword"
        placeholder="Password"
        required>

    <i
        class="fa-solid fa-eye password-toggle"
        onclick="togglePassword('loginPassword', this)">
    </i>
</div>

                <button class="main-btn">

                    Login

                </button>

            </form>

            <a href="google_login.php">
                <button class="google">

                    <i class="fa-brands fa-google"></i>

                    Login with Google

                </button>

            </a>

        </div>

        <!-- ================= REGISTER ================= -->

        <div class="form-container signup">
            <h1>Create Account</h1>

            <div class="brand">
                EVERYDAY
            </div>

            <p class="small">
                Start your fashion journey
            </p>

            <form action="register_login.php" method="POST">

                <input
                    type="text"
                    name="name"
                    placeholder="Full Name"
                    required>

                <input
                    type="email"
                    name="email"
                    placeholder="Email Address"
                    required>

                <div class="password-wrapper">
    <input
        type="password"
        name="password"
        id="registerPassword"
        placeholder="Password"
        required>

    <i
        class="fa-solid fa-eye password-toggle"
        onclick="togglePassword('registerPassword', this)">
    </i>
</div>

                <button
                    class="main-btn"
                    name="register">
                    Sign Up

                </button>

            </form>

            <a href="google_login.php">


                <button class="google">


                    <i class="fa-brands fa-google"></i>


                    Sign up with Google


                </button>



            </a>




        </div>


        <!-- ================= SWITCH PANEL ================= -->
   <div class="switch-container">

            <div class="switch">

                <h1 id="switch-title">

                    New Here?

                </h1>

                <p id="switch-text">

                    Create your account and discover new outfits

                </p>

                <button id="switchBtn">

                    Create Account

                </button>

            </div>


        </div>



    </div>

    <script>
        const container = document.getElementById("container");


        const btn = document.getElementById("switchBtn");


        const title = document.getElementById("switch-title");


        const text = document.getElementById("switch-text");



        btn.onclick = () => {


            container.classList.toggle("active");



            if (container.classList.contains("active")) {


                title.innerHTML = "Welcome Back";


                text.innerHTML =
                    "Login and continue your fashion journey";


                btn.innerHTML = "Login";



            } else {


                title.innerHTML = "New Here?";


                text.innerHTML =
                    "Create your account and discover new outfits";


                btn.innerHTML = "Create Account";


            }
        }
         setTimeout(() => {
        const alertBox = document.getElementById("alertMessage");

        if(alertBox){
            alertBox.classList.add("hide");

            setTimeout(() => {
                alertBox.remove();
            }, 200);
        }

    }, 2000);

    function togglePassword(inputId, icon) {

    const passwordInput = document.getElementById(inputId);

    if (passwordInput.type === "password") {

        passwordInput.type = "text";

        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");

    } else {

        passwordInput.type = "password";

        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
    </script>
</body>

</html>