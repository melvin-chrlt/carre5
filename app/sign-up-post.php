<?php

    require 'includes/config.php';

    if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['password2'])) {
        echo 'Missing input in the sign up form !';
    } else {
        $username = trim(htmlspecialchars($_POST['username']));
        $password = trim(htmlspecialchars($_POST['password']));
        $password2 = trim(htmlspecialchars($_POST['password2']));
    }

    if (strlen($username) < 3 || strlen($username) > 100) {
        header("Location:sign-up.php?message=<div class='alert alert-danger'>Username must be more than 3 characters...</div>");
        exit();
    }

    if (strlen($password) < 3 || strlen($password) > 100) {
        header("Location:sign-up.php?message=<div class='alert alert-danger'>Password must be more than 3 characters...</div>");
        exit();
    }

    try {
        $sqlVerif = 'SELECT COUNT(*) FROM user WHERE username = :username';
        $reqVerif = $db->prepare($sqlVerif);
        $reqVerif->bindValue(':username', $username, PDO::PARAM_STR);
        $reqVerif->execute();

        $resultVerif = $reqVerif->fetchColumn();
    } catch (PDOException $e) {
        echo 'Erreur :'.$e->getMessage();
        exit();
    }

    if ($resultVerif > 0) {
        header("Location:sign-up.php?message=<div class='alert alert-danger'>Username already exists</div>");
        exit();
    }

    if ($password !== $password2) {
        header("Location:sign-up.php?message=<div class='alert alert-danger'>Password doesn't match</div>");
        exit();
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $sqlInsert = 'INSERT INTO user (username,password) VALUES (:username,:password)';
        $reqInsert = $db->prepare($sqlInsert);
        $reqInsert->bindValue(':username', $username, PDO::PARAM_STR);
        $reqInsert->bindValue(':password', $password, PDO::PARAM_STR);

        $resultInsert = $reqInsert->execute();
    } catch (PDOException $e) {
        echo 'Erreur :'.$e->getMessage();
        exit();
    }

    if ($resultInsert) {
        header("Location:sign-in.php?message=<div class='alert alert-success'>Acount created ! Log in</div>");
        exit();
    } else {
        header("Location:sign-up.php?message=<div class='alert alert-danger'>Error try again !</div>");
        exit();
    }