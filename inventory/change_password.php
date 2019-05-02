<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SessionUtils.php");

    create_session();

    if (!empty($_SESSION["user"])) {

        $error = $_SESSION["error"];

        echo htmlentities("<!DOCTYPE html>
                    <html lang='en' dir='ltr'>
                    <head>
                        <meta charset='utf-8'>
                        <link rel='stylesheet' href='forgot_password.css'>
                        <link rel='stylesheet' href='base.css'>
                        <title>Recover password</title>
                    </head>
                    <body>
                    <div class='divform'>
                        <form class='form' action='../controller/ChangePassword.php' method='post'>
                            <label class='title'>Change password </label><br><br><br>
                            <input type='password' name='pass1' class='txtBox' placeholder='New password' autocomplete='off'><br>
                            <input type='password' name='pass2' class='txtBox' placeholder='Retype password' autocomplete='off'><br><br><br>
                            <label>$error</label><br>
                            <input type='submit' class='button red' value='Change password'>
                            <input type='button' onclick='location.href=\"login_page.html\"' class='button red' value='Cancel'>
                        </form>
                    </div>
                    </body>
                    </html>", ENT_HTML5, 'UTF-8', true);

    } else {

        header("Location: login_page.html");
        exit();
    }
