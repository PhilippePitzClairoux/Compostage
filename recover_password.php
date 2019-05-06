<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/user.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SecurityUtils.php");

    if (!empty($_POST["username"])) {

        try {

            $user = user::loadWithId(sanitize_input($_POST["username"]));

            $question = $user->getUserAuthQuestion();
            $username = $user->getUsername();

            echo "' class='button red' value='Cancel'>
                        </form>
                    </div>
                    </body>
                    </html>";

        } catch (Exception $e) {

            echo "Error log : " . $e->getMessage();
        }


    } else {

        echo "<p>Please input a username!</p><br>";

    }