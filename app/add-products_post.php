<?php

$auth = true;
require 'includes/config.php';
require 'includes/connect.php';

echo '<pre>';
var_dump($_POST);
echo '</pre>';

echo '<pre>';
var_dump($_FILES);
echo '</pre>';

//? Vérification de la validité du formulaire
if (empty($_POST['name']) || empty($_POST['description']) || empty($_POST['price'])) {
    header('Location:add-products.php?error=missingInput');
    exit();
} else {
    //? Si valide, initialisation des variables avec assainissement via trim et htmlspecialchars. On utilise floatval sur le prix, pour s'assurer d'avoir un prix décimal.
    $name = htmlspecialchars(trim($_POST['name']));
    $description = htmlspecialchars(trim($_POST['description']));
    $price = htmlspecialchars(floatval($_POST['price']));

    if (!empty($_POST['dlc'])) {
        $dlc = htmlspecialchars(trim($_POST['dlc']));
    } else {
        $dlc = null;
    }

    if (empty($_FILES['image']['name'])) {
        $imagePath = 'public/uploads/noimg.png';
        $image = null;
    }
}

if (null !== $dlc && $dlc <= date('Y-m-d')) {
    header('Location:add-products.php?error=pastDlc');
    exit();
}

// TODO : Upload image ici

/**
 * ! Pour uploader une image il faut :.
 *
 * TODO : Modifier le formulaire pour ajouter l'attribut enctype = "multipart/form-data" (<form enctype = "multipart/form-data"></form>)
 *
 * TODO : Récupérer l'image via $_FILES dans le back (sur la page _post)
 *
 * TODO : Initialiser la variable du fichier ($image = $_FILES['image'] ?? 'public/uploads/noimg.png';)
 *
 * TODO : Ajouter une condition if($image) qui permet de faire des vérifications : Voici une liste non exhaustive des verifications possibles : Taille, format, type MIME.
 *
 * TODO : Créer un chemin de dossier à l'identifiant unique (créé avec uniqid())
 *
 * TODO : Créer le dossier avec mkdir(dirname($imagePath))
 *
 * TODO : Réaliser l'upload du fichier avec move_uploaded_file($image['tmp_name'],$imagePath)
 *
 * TODO : Modifier la requête SQL pour prendre en compte l'upload de l'image
 *
 * TODO : Messages d'erreur
 */
if ($image) {
    if ($image['size'] > 10000000) {
        header('Location:add-products.php?error=imageTooBig');
        exit();
    }

    $valid_ext = ['jpg', 'jpeg', 'png'];
    $check_ext = strtolower(substr(strrchr($image['name'], '.'), 1));

    if (!in_array($check_ext, $valid_ext)) {
        header('Location:add-products.php?error=wrongFormat');
        exit();
    }

    $imagePath = 'public/uploads/'.uniqid().'/'.$image['name'];

    mkdir(dirname($imagePath));

    if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
        if (!in_array($check_ext, $valid_ext)) {
            header('Location:add-products.php?error=unknownError');
            exit();
        }
    }
}

$insertProduct = 'INSERT INTO product (name,description,price,dlc,image) VALUES(:name,:description,:price,:dlc,:image)';
$reqInsertProduct = $connexion->prepare($insertProduct);
$reqInsertProduct->bindValue(':name', $name, PDO::PARAM_STR);
$reqInsertProduct->bindValue(':description', $description, PDO::PARAM_STR);
$reqInsertProduct->bindValue(':price', $price);
$reqInsertProduct->bindValue(':dlc', $dlc, PDO::PARAM_STR);
$reqInsertProduct->bindValue(':image', $imagePath, PDO::PARAM_STR);

if ($reqInsertProduct->execute()) {
    header('Location:index.php?success=addedProduct');
    exit();
} else {
    header('Location:add-products.php?error=unknownError');
    exit();
}

/*
 * ! Etape logiques de l'ajout de produits (Back)
 *
 * TODO : Vérifier l'autorisation de l'utilisateur
 *
 * TODO : Vérifier que les champs requis soient remplis
 *
 * TODO : Initialisation des variables avec assainissement
 *
 * TODO : Créer la requête d'insertion et l'executer
 *
 * TODO : Messages d'erreur/de confirmation
 */