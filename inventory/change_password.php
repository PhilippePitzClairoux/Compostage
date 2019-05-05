<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SessionUtils.php");

    create_session();

    if (!empty($_SESSION["user"])) {

        $error = $_SESSION["error"];

        echo "<!DOCTYPE html>
                    <html lang='en' dir='ltr'>
                    <head>
                        <meta charset='utf-8'>
                        <link rel='stylesheet' href='forgot_password.css'>
                        <link rel='stylesheet' href='base.css'>
                        <script type='text/javascript' src='login_validation.js'></script>
                        <title>Recover password</title>
                    </head>
                    <body>
                    <div class='divform'>
                        <form class='form' action='../controller/ChangePassword.php' onsubmit='return validate()' method='post'>
                            <label class='title'>Change password </label><br><br><br>
                            <input type='password' name='pass1' id='password' class='txtBox' placeholder='New password' autocomplete='off'><br>
                            <input type='password' name='pass2' id='password' class='txtBox' placeholder='Retype password' autocomplete='off'><br><br><br>
                            <label id='error'>$error</label><br>
                            <input type='submit' class='button red' value='Change password'>
                            <input type='button' onclick='location.href=\"login_page.html\"' class='button red' value='Cancel'>
                        </form>
                    </div>
                    </body>
                    </html>";

    } else {

        header("Location: login_page.html");
        exit();
    }
