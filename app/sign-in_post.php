<?php

declare(strict_types=1);

require 'includes/config.php';

if (in_array('', $_POST)) {
    echo 'Missing input';
    header('Location:signIn.php?error=missingInput');
    exit();
} else {
    $username = trim(htmlspecialchars($_POST['username']));
    $password = htmlspecialchars($_POST['password']);
}

// ? Vérification de la validité des infos
if (filter_var($username, FILTER_VALIDATE_EMAIL) || strlen($username) < 3) {
    header("Location:sign-in.php?message=<div class='alert alert-danger'>Invalid username/password</div>");
    exit();
}

try {
    $sqlVerifUser = 'SELECT * FROM user WHERE username = :username LIMIT 1';
    $reqVerifUser = $db->prepare($sqlVerifUser);
    $reqVerifUser->bindValue(':username', $username, PDO::PARAM_STR);
    $reqVerifUser->execute();

    $user = $reqVerifUser->fetch();
} catch (\PDOException $e) {
    echo 'Erreur : '.$e->getMessage();
    exit();
}

if (!$user) {
    header("Location:sign-in.php?message=<div class='alert alert-danger'>Invalid username/password</div>");
    exit();
}

if (!password_verify($password, $user['password'])) {
    header("Location:sign-in.php?message=<div class='alert alert-danger'>Invalid username/password</div>");
    exit();
} else {
    $_SESSION['user'] = $user['username'];
    $_SESSION['id'] = $user['id'];
    header("Location:index.php?message=<div class='alert alert-success'>Connected</div>");
    exit();
}