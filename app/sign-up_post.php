<?php

require 'includes/connect.php';

echo '<pre>';
print_r($_POST);
echo '</pre>';

// if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['password2']))
//? Je vérifie que tous les champs ne sont pas vides
if (in_array('', $_POST)) {
    header('Location:sign-up.php?error=missingInput');
    exit();
} else {
    //? Si tous les champs sont remplis alors j'assigne les données reçues à des variables auquel j'applique htmlspecialchars. htmlspecialchars est une fonction qui permet de virer l'ensemble des balises HTML.

    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars($_POST['password']);
    $password2 = htmlspecialchars($_POST['password2']);
}

//* Il est possible d'utiliser un select (sans count) si vous utilisez la méthode fetchColumn() ensuite. Le temps d'exécution est légèrement plus élevé.
//* $verifUsername = "SELECT * FROM user WHERE username = :username";
$verifUsername = "SELECT COUNT(*) FROM user WHERE username = :username";
$reqVerifUsername = $connexion->prepare($verifUsername);
$reqVerifUsername->bindValue(':username', $username, PDO::PARAM_STR);
$reqVerifUsername->execute();

$resultatVerifUsername = $reqVerifUsername->fetchColumn();

if ($resultatVerifUsername > 0) {
    header('Location:sign-up.php?error=usernameExists');
    exit();
}

if ($password !== $password2) {
    header('Location:sign-up.php?error=differentPassword');
    exit();
}

$password = password_hash($password, PASSWORD_DEFAULT);

$insertUser = "INSERT INTO user (username,password) VALUES (:username,:password)";
$reqInsertUser = $connexion->prepare($insertUser);

$reqInsertUser->bindValue(':username', $username, PDO::PARAM_STR);
$reqInsertUser->bindValue(':password', $password, PDO::PARAM_STR);

$resultatInsertUser = $reqInsertUser->execute();

if ($resultatInsertUser) {
    echo "Inscription ok !";
}