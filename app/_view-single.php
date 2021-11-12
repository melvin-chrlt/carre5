<?php

$id = $_GET['id'];
// $viewProducts = "SELECT * from product";
//? Version non préparée : Dans des requêtes sans variables on peut utiliser query() plutot que prepare() car il n'y a pas de variables à echapper.
// $reqViewProducts = $connexion->query($viewProducts);
// $products = $reqViewProducts->fetchAll();

//* Version raccourcie de la requête ci-dessus :
//$products = $connexion->query("SELECT * from product")->fetchAll();

//? Version préparée : Elle contient des variables donc nécessaire
    $viewProduct = "SELECT * from product WHERE product_id = :product_id";
    $reqViewProduct = $connexion->prepare($viewProduct);
    $reqViewProduct->bindValue(':product_id',$id);
    $reqViewProduct->execute();
    $product = $reqViewProduct->fetch();
    if(empty($product)){
        echo "Erreur";
        echo '<meta http-equiv="refresh" content="0;URL=index.php?error=noId">';
        exit();
    }


    // echo '<pre>';
    // print_r($product);
    // echo'</pre>';
?>