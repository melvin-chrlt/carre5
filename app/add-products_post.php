<?php

$auth = true;
require 'includes/config.php';
require 'includes/connect.php';

echo '<pre>';
var_dump($_POST);
echo '</pre>';


//? Vérification de la validité du formulaire
if(empty($_POST['name']) || empty($_POST['description'])  || empty($_POST['price'])){
    header('Location:add-products.php?error=missingInput');
    exit();
}else{
    //? Si valide, initialisation des variables avec assainissement via trim et htmlspecialchars. On utilise floatval sur le prix, pour s'assurer d'avoir un prix décimal.
    $name = htmlspecialchars(trim($_POST['name']));
    $description = htmlspecialchars(trim($_POST['description']));
    $price = htmlspecialchars(floatval($_POST['price']));
    if(!empty($_POST['dlc'])){
        $dlc = htmlspecialchars(trim($_POST['dlc']));
    }else{
        $dlc = null;
    }
}
if($dlc !== null && $dlc <= date('Y-m-d')){
    header('Location:add-products.php?error=pastDlc');
    exit();
}

$insertProduct = "INSERT INTO product (name,description,price,dlc) VALUES(:name,:description,:price,:dlc)";
$reqInsertProduct = $connexion->prepare($insertProduct);
$reqInsertProduct->bindValue(':name',$name,PDO::PARAM_STR);
$reqInsertProduct->bindValue(':description',$description,PDO::PARAM_STR);
$reqInsertProduct->bindValue(':price',$price);
$reqInsertProduct->bindValue(':dlc',$dlc,PDO::PARAM_STR);

if($reqInsertProduct->execute()){
    header('Location:index.php?success=addedProduct');
    exit();
}else{
    header('Location:add-products.php?error=unknownError');
    exit();
}



/**
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