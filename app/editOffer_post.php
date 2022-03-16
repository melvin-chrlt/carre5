<?php

declare(strict_types=1);

require 'includes/config.php';

if (in_array('', $_POST)) {
    header("Location: editOffer.php?id={$_POST['product_id']}&error=missingInput");
} else {
    $name = htmlspecialchars(trim($_POST['name']));
    $description = htmlspecialchars(trim($_POST['description']));
    $price = htmlspecialchars(trim($_POST['price']));
    $dlc = htmlspecialchars(trim($_POST['dlc']));
    $product_id = htmlspecialchars(trim($_POST['product_id']));
}

if ($price <= 0) {
    header("Location:editOffer.php?id={$_POST['product_id']}&error=message=<div class='alert alert-danger'>Invalid price</div>");
    exit();
}

if (strlen($name) < 3) {
    header("Location:editOffer.php?id={$_POST['product_id']}&message=<div class='alert alert-danger'>Invalid Name</div>");
    exit();
}

try {
    $sqlUpdateOffer = 'UPDATE product SET name=:name, description=:description, price=:price, dlc=:dlc WHERE product_id=:product_id';
    $reqUpdateOffer = $db->prepare($sqlUpdateOffer);
    $reqUpdateOffer->execute([
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'dlc' => $dlc,
        'product_id' => $product_id,
    ]);

    header("Location:index.php?success=editSuccess&id={$product_id}");
} catch (PDOException $e) {
    echo 'Erreur : '.$e->getMessage();
    echo "<meta http-equiv='refresh' content='3;URL=editOffer.php?id={$product_id}'>";
}