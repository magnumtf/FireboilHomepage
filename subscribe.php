<?php
    // Start the session
    session_start();
?>
<?php
    print $_SERVER['SERVER_NAME'];
    print "<br />";
    print $_POST['email'];
    print "<br />";
    print $_POST['pswd'];
    print "<br />";
    print $_POST['subscribe'];
    print "<br />";
?>
