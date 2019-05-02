<?php

    include_once("../controller/data_management/user.php");

    if (!empty($_POST["username"])) {

        try {

            $user = user::loadWithId($_POST["username"]);

            $question = $user->getUserAuthQuestion();
            $username = $user->getUsername();

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
                        <form class='form' action='../controller/PasswordRecovery.php' method='post'>
                            <label class='title'>Riddle me this : <br> $question </label><br><br><br>
                            <input type='text' name='answer' class='txtBox' placeholder='Answer' autocomplete='off'><br><br><br>
                            <input type='hidden' name='username' value='$username'>
                            <input type='submit' name='confirmbtn' class='button red' value='Verify answer'>
                            <input type='button' onclick='location.href=\"login_page.html\"' class='button red' value='Cancel'>
                        </form>
                    </div>
                    </body>
                    </html>", ENT_HTML5, 'UTF-8', true);

        } catch (Exception $e) {

            echo "Error log : " . $e->getMessage();
        }


    } else {

        echo "<p>Please input a username!</p><br>";

    }