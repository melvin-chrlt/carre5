<?php

session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location:index.php');
}

if (empty($_SESSION) && isset($auth)) {
    header('Location:sign-in.php?auth');
    exit();
}