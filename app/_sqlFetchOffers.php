<?php

// ? Requête SQL qui permet de récupérer les offres (sauf celles du user connecté)
    $sqlOffers = 'SELECT * FROM product';
    $reqOffers = $db->prepare($sqlOffers);
    $reqOffers->bindValue(':user', $user);
    $reqOffers->execute();

    $offers = $reqOffers->fetchAll();