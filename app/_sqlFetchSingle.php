<?php

// ? Requête SQL qui permet de récupérer une offre (une seule en fonction de son id)
try{
    $offer_id = $_GET['id'];
    $sqlOffer = 'SELECT * FROM product WHERE product_id = :product_id';
    $reqOffer = $db->prepare($sqlOffer);
    $reqOffer->bindValue(':product_id', $offer_id);
    $reqOffer->execute();

    $offer = $reqOffer->fetch();   
} catch (PDOException $e){
    echo 'Erreur : '.$e->getMessage();
}