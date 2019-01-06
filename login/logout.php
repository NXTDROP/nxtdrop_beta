<?php
    session_start();
    session_unset();
    session_destroy();

    if(isset($_COOKIE['rememberme'])) {
        setcookie('rememberme', null, -1);
    }

    header("Location: home");
    exit();
?>