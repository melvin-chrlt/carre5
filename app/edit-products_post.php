<?php

$auth = true;
require 'includes/config.php';
require 'includes/connect.php';

echo '<pre>';
var_dump($_POST);
echo '</pre>';

//? Deux méthodes pour récupérer l'id de la page d'avant :
//* 1. Je découpe ma chaine de caractère de l'url en deux à partir du signe égal '=', et je récupère la partie qui vient après (donc l'id)
$getId = explode('=', $_SERVER['HTTP_REFERER'])[1];
//* 2. Je récupère la partie de la chaîne qui commence par un 'id' et je supprimer tout le reste (y compris la partie 'id=')
$altGetId = substr(strchr($_SERVER['HTTP_REFERER'], 'id'), 3);
echo '<pre>';
var_dump($getId);
var_dump($altGetId);
echo '</pre>';

if (!($getId == $_POST['id'])) {
    header("Location:edit-products.php?id=$getId&error=malformedInput");
    exit();
}

//? Vérification de la validité du formulaire
if (empty($_POST['name']) || empty($_POST['description']) || empty($_POST['price'])) {
    header("Location:edit-products.php?id=$getId&error=missingInput");
    exit();
} else {
    //? Si valide, initialisation des variables avec assainissement via trim et htmlspecialchars. On utilise floatval sur le prix, pour s'assurer d'avoir un prix décimal.
    $name = htmlspecialchars(trim($_POST['name']));
    $description = htmlspecialchars(trim($_POST['description']));
    $price = htmlspecialchars(floatval($_POST['price']));
    $id = intval($_POST['id']);

    if (!empty($_POST['dlc'])) {
        $dlc = htmlspecialchars(trim($_POST['dlc']));
    } else {
        $dlc = null;
    }

    if (empty($_FILES['image']['name'])) {
        $imagePath = ''; // L'ancien truc
        $image = null;
    }
}

if (null !== $dlc && $dlc <= date('Y-m-d')) {
    header("Location:edit-products.php?id=$getId&error=pastDlc");
    exit();
}

if ($image) {
    if ($image['size'] > 10000000) {
        header("Location:edit-products.php?id=$getId&error=imageTooBig");
        exit();
    }

    $valid_ext = ['jpg', 'jpeg', 'png'];
    $check_ext = strtolower(substr(strrchr($image['name'], '.'), 1));

    if (!in_array($check_ext, $valid_ext)) {
        header("Location:edit-products.php?id=$getId&error=wrongFormat");
        exit();
    }

    $imagePath = 'public/uploads/'.uniqid().'/'.$image['name'];

    mkdir(dirname($imagePath));

    if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
        if (!in_array($check_ext, $valid_ext)) {
            header("Location:edit-products.php?id=$getId&error=unknownError");
            exit();
        }
    }
}

$editProduct = 'UPDATE product SET name=:name,description=:description, price=:price, dlc=:dlc, image=:image WHERE product_id=:id';
$reqEditProduct = $connexion->prepare($editProduct);
$reqEditProduct->bindValue(':name', $name, PDO::PARAM_STR);
$reqEditProduct->bindValue(':description', $description, PDO::PARAM_STR);
$reqEditProduct->bindValue(':price', $price);
$reqEditProduct->bindValue(':dlc', $dlc, PDO::PARAM_STR);
$reqEditProduct->bindValue(':image', $imagePath, PDO::PARAM_STR);
$reqEditProduct->bindValue(':id', $id);

// if ($reqEditProduct->execute()) {
//     header("Location:index.php?success=addedProduct");
//     exit();
// } else {
//     header("Location:edit-products.php?id=$getId&error=unknownError");
//     exit();
// }