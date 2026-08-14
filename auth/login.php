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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --sand: #EDE7DD;
            --sand-deep: #E1D8C6;
            --white: #FFFFFF;
            --ink: #232220;
            --ink-soft: #6B6862;
            --panel: #201F1D;
            --panel-soft: #34322F;
            --gold: #C9A227;
            --forest: #35533F;
            --error-bg: #FBEAEA;
            --error-text: #A8402F;
            --error-border: #F0C4B8;
            --ease: cubic-bezier(.65, 0, .35, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Inter', Arial, sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 15% 10%, #F4EFE6 0%, transparent 45%),
                radial-gradient(circle at 85% 90%, #E6DCC8 0%, transparent 40%),
                var(--sand);
            padding: 20px;
        }

        /* ================= Container ================= */

        .container {
            width: 850px;
            max-width: 100%;
            height: 540px;
            background: var(--white);
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 30px 60px -20px rgba(35, 34, 32, .28), 0 2px 8px rgba(35, 34, 32, .06);
        }

        /* ================= Forms ================= */

        .form-container {
            position: absolute;
            top: 0;
            height: 100%;
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 48px 56px;
            transition: transform .7s var(--ease), opacity .45s ease;
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

        .container.active .login {
            transform: translateX(100%);
            opacity: 0;
        }

        .container.active .signup {
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
        }

        /* eyebrow + wordmark */

        .eyebrow {
            font-size: 11px;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: var(--ink-soft);
            font-weight: 600;
            margin-bottom: 6px;
        }

        .brand {
            font-family: 'Fraunces', serif;
            font-size: 26px;
            font-weight: 600;
            letter-spacing: .04em;
            margin-bottom: 6px;
            position: relative;
            display: inline-block;
            text-align:center
        }

        .brand svg {
            display: block;
            width: 100%;
            height: 6px;
            margin-top: 2px;
        }

        .brand svg path {
            fill: none;
            stroke: var(--gold);
            stroke-width: 2;
            stroke-linecap: round;
            stroke-dasharray: 4 6;
            stroke-dashoffset: 140;
            animation: stitch-in 1.1s .15s var(--ease) forwards;
        }

        @keyframes stitch-in {
            to { stroke-dashoffset: 0; }
        }

        h1 {
            font-family: 'Fraunces', serif;
            font-weight: 600;
            font-size: 30px;
            margin-bottom: 4px;
        }

        .small {
            color: var(--ink-soft);
            font-size: 14px;
            margin-bottom: 26px;
        }

        form {
            width: 100%;
        }

        /* animate fields in, staggered, each time a panel becomes active */

        form .field,
        form > button,
        form ~ a button {
            animation: rise-in .55s var(--ease) both;
        }

        .login form .field:nth-child(1) { animation-delay: .05s; }
        .login form .field:nth-child(2) { animation-delay: .12s; }
        .login form > button              { animation-delay: .19s; }

        .signup form .field:nth-child(1) { animation-delay: .05s; }
        .signup form .field:nth-child(2) { animation-delay: .11s; }
        .signup form .field:nth-child(3) { animation-delay: .17s; }
        .signup form > button              { animation-delay: .23s; }

        @keyframes rise-in {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ================= Floating-label fields ================= */

        .field {
            position: relative;
            width: 100%;
            margin: 14px 0;
        }

        .field input {
            width: 100%;
            padding: 14px 4px 8px;
            border: none;
            border-bottom: 1.5px solid #D8D2C4;
            outline: none;
            font-family: 'Inter', sans-serif;
            font-size: 15px;
            background: transparent;
            color: var(--ink);
            transition: border-color .25s var(--ease);
        }

        .field.password input {
            padding-right: 30px;
        }

        .field label {
            position: absolute;
            left: 4px;
            top: 14px;
            font-size: 15px;
            color: var(--ink-soft);
            pointer-events: none;
            transition: transform .2s var(--ease), color .2s var(--ease), font-size .2s var(--ease);
            transform-origin: left top;
        }

        .field input:focus + label,
        .field input:not(:placeholder-shown) + label {
            transform: translateY(-12px);
            font-size: 11px;
            letter-spacing: .04em;
            color: var(--forest);
        }

        /* animated underline that "sews" itself on focus */

        .field::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -1.5px;
            height: 1.5px;
            width: 100%;
            background: repeating-linear-gradient(90deg, var(--gold) 0 6px, transparent 6px 11px);
            background-size: 200% 100%;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform .35s var(--ease);
        }

        .field input:focus ~ .password-toggle,
        .field input:focus {
            border-bottom-color: transparent;
        }

        .field input:focus ~ label {
            color: var(--forest);
        }

        .field:has(input:focus)::after {
            transform: scaleX(1);
        }

        .password-toggle {
            position: absolute;
            right: 4px;
            top: 14px;
            cursor: pointer;
            color: var(--ink-soft);
            font-size: 14px;
            transition: color .2s ease;
        }

        .password-toggle:hover {
            color: var(--ink);
        }

        /* ================= Buttons ================= */

        button {
            width: 100%;
            padding: 14px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 14px;
            letter-spacing: .02em;
            margin-top: 18px;
            transition: transform .18s var(--ease), box-shadow .18s var(--ease), background .2s ease;
        }

        .main-btn {
            background: var(--ink);
            color: var(--white);
        }

        .main-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -8px rgba(35, 34, 32, .45);
            background: #34322F;
        }

        .main-btn:active {
            transform: translateY(0);
        }

        .google {
            background: var(--white);
            border: 1.5px solid #E4DECF;
            color: var(--ink);
            margin-top: 10px;
        }

        .google:hover {
            transform: translateY(-2px);
            border-color: #CFC6AF;
            box-shadow: 0 8px 16px -10px rgba(35, 34, 32, .35);
        }

        .google i {
            color: #4285F4;
            margin-right: 8px;
        }

        a { text-decoration: none; }

        /* ================= Switch panel ================= */

        .switch-container {
            position: absolute;
            right: 0;
            width: 50%;
            height: 100%;
            background: var(--panel);
            color: var(--white);
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            transition: transform .7s var(--ease);
            overflow: hidden;
        }

        .container.active .switch-container {
            transform: translateX(-100%);
        }

        /* ambient drifting glow, subtle */

        .switch-container::before {
            content: "";
            position: absolute;
            width: 340px;
            height: 340px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(201, 162, 39, .28) 0%, transparent 70%);
            top: -80px;
            left: -60px;
            animation: drift 12s ease-in-out infinite alternate;
        }

        @keyframes drift {
            from { transform: translate(0, 0); }
            to   { transform: translate(40px, 60px); }
        }

        /* stitched seam framing the copy */

        .switch {
            padding: 40px 44px;
            position: relative;
            z-index: 2;
        }

        .switch::before,
        .switch::after {
            content: "";
            display: block;
            height: 2px;
            width: 56px;
            margin: 0 auto 22px;
            background: repeating-linear-gradient(90deg, var(--gold) 0 5px, transparent 5px 9px);
            background-size: 200% 100%;
            animation: stitch-run 6s linear infinite;
        }

        .switch::after {
            margin: 22px auto 0;
        }

        @keyframes stitch-run {
            to { background-position: -200% 0; }
        }

        .switch h1 {
            font-size: 30px;
            color: var(--white);
        }

        .switch p {
            color: #C9C5BC;
            font-size: 14px;
            line-height: 1.5;
            margin: 10px 0 24px;
        }

        .switch button {
            background: var(--white);
            color: var(--ink);
            width: auto;
            padding: 13px 34px;
            margin-top: 0;
        }

        .switch button:hover {
            background: var(--gold);
            color: var(--panel);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -8px rgba(201, 162, 39, .5);
        }

        /* ================= Alert ================= */

        .alert {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 350px;
            max-width: calc(100% - 40px);
            padding: 12px 16px;
            border-radius: 8px;
            text-align: center;
            font-size: 13.5px;
            z-index: 20;
            animation: alert-in .35s var(--ease);
            transition: opacity .4s ease, transform .4s ease;
        }

        .alert.hide {
            opacity: 0;
            transform: translate(-50%, -8px);
            pointer-events: none;
        }

        @keyframes alert-in {
            from { opacity: 0; transform: translate(-50%, -10px); }
            to   { opacity: 1; transform: translate(-50%, 0); }
        }

        .alert-danger {
            background: var(--error-bg);
            color: var(--error-text);
            border: 1px solid var(--error-border);
        }

        /* ================= Mobile ================= */

        @media (max-width: 700px) {
            .container {
                width: 100%;
                height: auto;
                border-radius: 14px;
            }

            .form-container {
                position: relative;
                width: 100%;
                padding: 40px 28px 32px;
                transition: opacity .35s ease;
                transform: none !important;
            }

            .login, .signup { left: 0; }

            .signup {
                display: none;
                position: absolute;
                top: 0;
            }

            .container.active .login {
                display: none;
                opacity: 1;
            }

            .container.active .signup {
                display: flex;
                position: relative;
                opacity: 1;
            }

            .switch-container {
                position: relative;
                width: 100%;
                height: auto;
                transform: none !important;
                padding: 26px 20px;
            }

            .switch {
                padding: 0;
            }

            .switch::before, .switch::after {
                display: none;
            }

            .switch h1 { font-size: 20px; }
            .switch p { margin: 6px 0 16px; }
            .switch button { padding: 11px 28px; font-size: 13px; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: .001ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .001ms !important;
            }
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

            <div class="eyebrow">Welcome back</div>
            <div class="brand">
                EVERYDAY
                <svg viewBox="0 0 140 6" preserveAspectRatio="none"><path d="M0 3 H140" /></svg>
            </div>

            <h1>Log in</h1>
            <p class="small">Continue your style, where you left off</p>

            <form action="login_process.php" method="POST">

                <div class="field">
                    <input type="email" name="email" id="loginEmail" placeholder=" " required>
                    <label for="loginEmail">Email address</label>
                </div>

                <div class="field password">
                    <input type="password" name="password" id="loginPassword" placeholder=" " required>
                    <label for="loginPassword">Password</label>
                    <i class="fa-solid fa-eye password-toggle" onclick="togglePassword('loginPassword', this)"></i>
                </div>

                <button class="main-btn">Log in</button>

            </form>

            <a href="google_login.php">
                <button class="google">
                    <i class="fa-brands fa-google"></i>
                    Continue with Google
                </button>
            </a>

        </div>

        <!-- ================= REGISTER ================= -->

        <div class="form-container signup">

            <div class="eyebrow">Join us</div>
            <div class="brand">
                EVERYDAY
                <svg viewBox="0 0 140 6" preserveAspectRatio="none"><path d="M0 3 H140" /></svg>
            </div>

            <h1>Create account</h1>
            <p class="small">Start your fashion journey with us</p>

            <form action="register_login.php" method="POST">

                <div class="field">
                    <input type="text" name="name" id="registerName" placeholder=" " required>
                    <label for="registerName">Full name</label>
                </div>

                <div class="field">
                    <input type="email" name="email" id="registerEmail" placeholder=" " required>
                    <label for="registerEmail">Email address</label>
                </div>

                <div class="field password">
                    <input type="password" name="password" id="registerPassword" placeholder=" " required>
                    <label for="registerPassword">Password</label>
                    <i class="fa-solid fa-eye password-toggle" onclick="togglePassword('registerPassword', this)"></i>
                </div>

                <button class="main-btn" name="register">Create account</button>

            </form>

            <a href="google_login.php">
                <button class="google">
                    <i class="fa-brands fa-google"></i>
                    Continue with Google
                </button>
            </a>

        </div>


        <!-- ================= SWITCH PANEL ================= -->

        <div class="switch-container">

            <div class="switch">

                <h1 id="switch-title">New here?</h1>

                <p id="switch-text">Create your account and discover new outfits</p>

                <button id="switchBtn">Create account</button>

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
                title.innerHTML = "Welcome back";
                text.innerHTML = "Log in and continue your fashion journey";
                btn.innerHTML = "Log in";
            } else {
                title.innerHTML = "New here?";
                text.innerHTML = "Create your account and discover new outfits";
                btn.innerHTML = "Create account";
            }
        }

        setTimeout(() => {
            const alertBox = document.getElementById("alertMessage");
            if (alertBox) {
                alertBox.classList.add("hide");
                setTimeout(() => alertBox.remove(), 400);
            }
        }, 2500);

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