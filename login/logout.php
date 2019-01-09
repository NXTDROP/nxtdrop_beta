<?php
    session_start();
    session_unset();
    session_destroy();

    unset($_COOKIE['rememberme']);
    setcookie("rememberme", "", time() - 3600, '/');

    header("Location: home");
    exit();
?>