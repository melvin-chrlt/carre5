<?php

//? Version non préparée : Dans des requêtes sans variables on peut utiliser query() plutot que prepare() car il n'y a pas de variables à echapper.
    $viewProducts = "SELECT * from product";
    $reqViewProducts = $connexion->query($viewProducts);
    $products = $reqViewProducts->fetchAll();

    //* Version raccourcie de la requête ci-dessus :
    //$products = $connexion->query("SELECT * from product")->fetchAll();
    
//? Version préparée : Elle ne contient pas de variables donc pas nécessaire
    // $reqViewProducts = $connexion->prepare($viewProducts);
    // $reqViewProducts->execute();
    // $products = $reqViewProducts->fetchAll();



    // echo '<pre>';
    // print_r($products);
    // echo'</pre>';
?>