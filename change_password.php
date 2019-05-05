<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SessionUtils.php");

    create_session();

    if (!empty($_SESSION["user"])) {

        $error = $_SESSION["error"];

        echo "' class='button red' value='Cancel'>
                        </form>
                    </div>
                    </body>
                    </html>";

    } else {

        header("Location: index.html");
        exit();
    }
