<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= base_url('assets/img/'); ?>rb.png">

    <!-- ===== BOX ICONS ===== -->
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

    <!-- ===== SWAL JS ===== -->
    <script src="<?= base_url('assets/app-assets/template/presensi-abdul/plugins/swal/sweetalert2.all.js'); ?>"></script>

    <title>E-Presensi</title>

    <!--===== MAIN CSS =====-->
    <style>
        /*===== GOOGLE FONTS =====*/
        @import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap");

        /*===== VARIABLES CSS =====*/
        :root {
            /*===== Colores =====*/
            --first-color: darkblue;
            --first-color-dark: #23004D;
            --first-color-light: #A49EAC;
            --first-color-lighten: #F2F2F2;

            /*===== Font and typography =====*/
            --body-font: 'Open Sans', sans-serif;
            --h1-font-size: 1.5rem;
            --normal-font-size: .938rem;
            --small-font-size: .813rem;
        }

        @media screen and (min-width: 768px) {
            :root {
                --normal-font-size: 1rem;
                --small-font-size: .875rem;
            }
        }

        /*===== BASE =====*/
        *,
        ::before,
        ::after {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: var(--body-font);
            font-size: var(--normal-font-size);
            color: var(--first-color-dark);
        }

        h1 {
            margin: 0;
        }

        a {
            text-decoration: none;
        }

        img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        /*===== LOGIN =====*/
        .login {
            display: grid;
            grid-template-columns: 100%;
            height: 100vh;
            margin-left: 1.5rem;
            margin-right: 1.5rem;
        }

        .login__content {
            display: grid;
        }

        .login__img {
            justify-self: center;
        }

        .login__img img {
            width: 310px;
            margin-top: 1.5rem;
        }

        .login__forms {
            position: relative;
            height: 368px;
        }

        .login__registre,
        .login__create {
            position: absolute;
            bottom: 1rem;
            width: 100%;
            background-color: var(--first-color-lighten);
            padding: 2rem 1rem;
            border-radius: 1rem;
            text-align: center;
            box-shadow: 0 8px 20px rgba(35, 0, 77, .2);
            animation-duration: .4s;
            animation-name: animate-login;
        }

        @keyframes animate-login {
            0% {
                transform: scale(1, 1);
            }

            50% {
                transform: scale(1.1, 1.1);
            }

            100% {
                transform: scale(1, 1);
            }
        }

        .login__title {
            font-size: var(--h1-font-size);
            margin-bottom: 2rem;
        }

        .login__box {
            display: grid;
            grid-template-columns: max-content 1fr;
            column-gap: .5rem;
            padding: 1.125rem 1rem;
            background-color: #FFF;
            margin-top: 1rem;
            border-radius: .5rem;
        }

        .login__icon {
            font-size: 1.5rem;
            color: var(--first-color);
        }

        .login__input {
            border: none;
            outline: none;
            font-size: var(--normal-font-size);
            font-weight: 700;
            color: var(--first-color-dark);
        }

        .login__input::placeholder {
            font-size: var(--normal-font-size);
            font-family: var(--body-font);
            color: var(--first-color-light);
        }

        .login__forgot {
            display: block;
            width: max-content;
            margin-left: auto;
            margin-top: .5rem;
            font-size: var(--small-font-size);
            font-weight: 600;
            color: var(--first-color-light);
        }

        .login__button {
            display: block;
            width: 100%;
            border: none;
            padding: 1rem;
            margin: 2rem 0;
            background-color: var(--first-color);
            color: #FFF;
            font-weight: 600;
            text-align: center;
            border-radius: .5rem;
            transition: .3s;
        }

        .login__button:hover {
            background-color: var(--first-color-dark);
        }

        .login__account,
        .login__signin,
        .login__signup {
            font-weight: 600;
            font-size: var(--small-font-size);
        }

        .login__account {
            color: var(--first-color-dark);
        }

        .login__signin,
        .login__signup {
            color: var(--first-color);
            cursor: pointer;
        }

        .login__social {
            margin-top: 2rem;
        }

        .login__social-icon {
            font-size: 1.5rem;
            color: var(--first-color-dark);
            margin: 0 1.5rem;
        }

        /* Presensi */
        .copyright {
            position: absolute;
            left: 10px;
            top: 10px;
            font-size: 12px;
        }

        /*Show login*/
        .block {
            display: block;
        }

        /*Hidden login*/
        .none {
            display: none;
        }

        /* ===== MEDIA QUERIES =====*/
        @media screen and (min-width: 576px) {
            .login__forms {
                width: 348px;
                justify-self: center;
            }
        }

        @media screen and (min-width: 1024px) {
            .login {
                height: 100vh;
                overflow: hidden;
            }

            .login__content {
                grid-template-columns: repeat(2, max-content);
                justify-content: center;
                align-items: center;
                margin-left: 10rem;
            }

            .login__img {
                display: flex;
                width: 600px;
                height: 570px;
                background-color: var(--first-color-lighten);
                border-radius: 1rem;
                padding-left: 1rem;
            }

            .login__img img {
                width: 390px;
                margin-top: 0;
            }

            .login__registre,
            .login__create {
                left: -11rem;
            }

            .login__registre {
                bottom: -2rem;
            }

            .login__create {
                bottom: -5.5rem;
            }
        }
    </style>
</head>

<body style="background-color: darkblue;">
    <div class="login">
        <div class="login__content">
            <div class="login__img">
                <img src="<?= base_url('assets/app-assets/auth/img/'); ?>login-not-css.svg" alt="">
            </div>

            <div class="login__forms">
                <form action="" method="POST" class="login__registre <?= $login_registre; ?>" id="login-in">
                    <!-- <div class="copyright"><small><strong>E-Presensi</strong></small></div> -->
                    <h1 class="login__title">Sign In</h1>

                    <div class="login__box">
                        <i class='bx bx-user login__icon'></i>
                        <input type="text" name="username" placeholder="Username" class="login__input" autocomplete="off" required>
                    </div>

                    <div class="login__box">
                        <i class='bx bx-lock-alt login__icon'></i>
                        <input type="password" name="password" placeholder="Password" class="login__input" autocomplete="off" required>
                    </div>
                    <button type="submit" class="login__button">Sign In</button>

                    <?php $admin = $this->db->get('admin')->result();
                    if (count($admin) < 1) : ?>
                        <div>
                            <span class="login__account">Akun Admin Belum Terdaftar.</span>
                            <span class="login__signin" id="sign-up">Sign Up</span>
                        </div>
                    <?php endif; ?>
                </form>

                <form action="<?= base_url('auth/registration'); ?>" method="POST" class="login__create <?= $login_create; ?>" id="login-up">
                    <div class="login__create_inside">
                        <!-- <div class="copyright"><small><strong>E-Presensi</strong></small></div> -->
                        <h1 class="login__title">Create Account</h1>

                        <div class="login__box">
                            <i class='bx bx-user login__icon'></i>
                            <input type="text" placeholder="Username" name="username" class="login__input" required autocomplete="off">
                        </div>

                        <div class="login__box">
                            <i class='bx bx-at login__icon'></i>
                            <input type="text" placeholder="Email" name="email" class="login__input" required autocomplete="off">
                        </div>

                        <div class="login__box">
                            <i class='bx bx-lock-alt login__icon'></i>
                            <input type="password" placeholder="Password" name="password" class="login__input" required autocomplete="off">
                        </div>

                        <button type="submit" class="login__button">Sign Up</button>

                        <!-- <div>
                            <span class="login__account">Already have an Account ?</span>
                            <span class="login__signup" id="sign-in">Sign In</span>
                        </div> -->

                        <!-- <div class="login__social">
                            <a href="#" class="login__social-icon"><i class='bx bxl-facebook'></i></a>
                            <a href="#" class="login__social-icon"><i class='bx bxl-twitter'></i></a>
                            <a href="#" class="login__social-icon"><i class='bx bxl-google'></i></a>
                        </div> -->
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--===== MAIN JS =====-->
    <script>
        /*===== LOGIN SHOW and HIDDEN =====*/
        const signUp = document.getElementById('sign-up'),
            signIn = document.getElementById('sign-in'),
            loginIn = document.getElementById('login-in'),
            loginUp = document.getElementById('login-up')


        signUp.addEventListener('click', () => {
            // Remove classes first if they exist
            loginIn.classList.remove('block')
            loginUp.classList.remove('none')

            // Add classes
            loginIn.classList.toggle('none')
            loginUp.classList.toggle('block')
        })

        signIn.addEventListener('click', () => {
            // Remove classes first if they exist
            loginIn.classList.remove('none')
            loginUp.classList.remove('block')

            // Add classes
            loginIn.classList.toggle('block')
            loginUp.classList.toggle('none')
        })
    </script>
    <?= $this->session->flashdata('pesan'); ?>
</body>

</html>