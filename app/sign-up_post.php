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

// $pdo->fetch(); //* J'obtiens un array qui contient : un array indexé avec mes valeurs, et un array associatif avec mes valeurs, mais seulement pour la première ligne que renvoie ma BDD.

// $pdo->fetchColumn(); //* J'obtiens un nombre qui quantifie le nombre de lignes qui correspondent à ma requête.

// $pdo->fetchAll(); //* J'obtiens un array qui contient : un array indexé avec mes valeurs, et un array associatif avec mes valeurs, mais cette fois pour tous les résultats de ma requête.

$resultatVerifUsername = $reqVerifUsername->fetchColumn();

//? Je compte le nom d'utilisateur qui possède l'username souhaité
if ($resultatVerifUsername > 0) {
    header('Location:sign-up.php?error=usernameExists');
    exit();
}

//? Je vérifie que les mots de passe correspondent
if ($password !== $password2) {
    header('Location:sign-up.php?error=differentPasswords');
    exit();
}

//? Cryptage (en vrai hashage) du mot de passe
$password = password_hash($password, PASSWORD_DEFAULT);

//? Requête préparée d'insertion dans la BDD

$insertUser = "INSERT INTO user (username,password) VALUES (:username,:password)";
$reqInsertUser = $connexion->prepare($insertUser);

$reqInsertUser->bindValue(':username', $username, PDO::PARAM_STR);
$reqInsertUser->bindValue(':password', $password, PDO::PARAM_STR);

$resultatInsertUser = $reqInsertUser->execute();

if ($resultatInsertUser) {
    header('Location:sign-up.php?success=loginSuccessful');
    exit();
}

/**
 * ! Etapes logiques de l'inscription
 *
 *  TODO Vérification intro : vérifier que le formulaire est rempli ou que les champs nécessaires le soient.
 *
 *  TODO : Initialisation variables : Assainissement des variables
 *
 *  TODO Verification email : Nécessaire quand il y a un email
 *
 *  TODO Vérification email & username dans la BDD : Pour que les id ne soit pas existants
 *
 *  TODO Vérification mdp : Concordance password
 *
 *  TODO Hashage du mdp : Crypter le mot de passe
 *
 *  TODO Enregistrement données utilisateur dans la BDD
 *
 *  TODO Message d'erreur
 */