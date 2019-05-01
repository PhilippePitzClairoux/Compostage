<?php include_once("../controller/SessionUtils.php");
  create_session();

  if (!check_if_valid_session_exists())
      header("Location:login_page.html");

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Welcome <?php echo $_SESSION["user"]->getUsername() ?></title>
    </head>
    <body>

        <h1>Welcome <?php echo $_SESSION["user"]->getUsername() ?>!</h1>
        <form target="_self" action="../controller/LogoutManager.php">
            <button title="Logout">Logout</button>
        </form>



    </body>
</html>