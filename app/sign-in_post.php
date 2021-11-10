<?php

require 'includes/config.php';
require 'includes/connect.php';

echo '<pre>';
print_r($_POST);
echo '</pre>';

//? Je vérifie que mon formulaire est rempli
if (empty($_POST['username']) || empty($_POST['password'])) {
    header('Location:sign-in.php?error=missingInput');
    exit();
} else {
    //? S'il est rempli, j'initialise les variables en les assainissant
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
}

try {
    //? Requête préparée de récupération de l'utilisateur
    //* Dans le cas d'un champ unique qui serait utilisable avec l'username ou l'email on écrirait la requête de cette façon.
    // $verifUsername = "SELECT * FROM user WHERE username = :username OR email = :email";
    $verifUsername = "SELECT * FROM user WHERE username = :username LIMIT 1";
    $reqVerifUsername = $connexion->prepare($verifUsername);
    $reqVerifUsername->bindValue(':username', $username, PDO::PARAM_STR);
    $reqVerifUsername->execute();

    $user = $reqVerifUsername->fetch();

} catch (PDOException $e) {
    $connexion = null;
    echo 'Erreur : ' . $e->getMessage();
}

if ($user) {
    echo '<pre>';
    print_r($user);
    echo '</pre>';

    if (!password_verify($password, $user['password'])) {
        header('Location:sign-in.php?error=passwordNotMatch');
        exit();
    } else {
        $_SESSION['user'] = $user["username"];
        header('Location:index.php');
    }
}

/**
 * ! Etapes logiques de la connexion :
 *
 * TODO : Vérif intro : formulaire rempli/champs nécessaires remplis
 *
 * TODO : Initialisation variables : Assainissement des variables
 *
 * TODO : Vérification de l'identifiant unique
 *
 * TODO : Vérification du mot de passe associé à l'identifiant unique
 *
 * TODO : Connexion via création d'une session
 *
 * TODO : Messages d'erreur
 */