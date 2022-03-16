<?php

    require 'includes/db.php';
    session_start();

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if (isset($_GET['logout'])) {
        session_destroy();
        header('Location:index.php');
    }

    if (empty($_SESSION)) {
        if (isset($auth)) {
            header('Location:sign-in.php');
            exit();
        }
        $user = null;
    } else {
        $user = $_SESSION['id'];
    }