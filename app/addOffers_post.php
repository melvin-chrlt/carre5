<?php

declare(strict_types=1);
$auth = true;
require 'includes/config.php';

$author = $_SESSION['id'];

if (empty($_POST['name']) || empty($_POST['description']) || empty($_POST['price']) || empty($_POST['dlc'])) {
    header('Location:addOffers.php?error=missingInput');
    exit();
} else {
    $name = htmlspecialchars(trim($_POST['name']));
    $description = htmlspecialchars(trim($_POST['description']));
    $price = htmlspecialchars(trim($_POST['price']));
    $dlc = htmlspecialchars(trim($_POST['dlc']));
    $image = $_FILES['image'];
}

if($price < 0){
    header("Location:addOffers.php?message=<div class='alert alert-danger'>Invalid price</div>");
    exit();
}

if(strlen($name) < 3){
    header("Location:addOffers.php?message=<div class='alert alert-danger'>Name must be more than 3 characters...</div>");
    exit();
}

if($image['size'] > 0 && $image['size'] <= 1000000){
    $valid_ext = ['jpg', 'jpeg', 'png', 'gif'];
    $get_ext = strtolower(substr(strrchr($image['name'], '.'),1));

    if(!in_array($get_ext, $valid_ext)){
        header("Location:addOffers.php?message=<div class='alert alert-danger'>Invalid format image</div>");
        exit();
    }
    
    $valid_type = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
    if(!in_array($image['type'], $valid_type)){
        header("Location:addOffers.php?message=<div class='alert alert-danger'>Invalid format file</div>");
        exit();
    }

    $image_path = 'public/uploads'.uniqid().'/'.$image['name'];

    mkdir(dirname($image_path));

    if(!move_uploaded_file($image['tmp_name'], $image_path)){
        header("Location:addOffers.php?message=<div class='alert alert-danger'>Upload</div>");
        exit();
    }
}

try {
    $sqlInsertOffer = 'INSERT INTO product (name,description,price,dlc,image) VALUES (:name, :description, :price, :dlc, :image)';
    $reqInsertOffer = $db->prepare($sqlInsertOffer);
    $reqInsertOffer->execute(
        [':name' => $name, ':description' => $description, ':price' => $price, ':dlc' => $dlc, ':image' => $image_path]
    );

    $insert = $db->lastInsertId();
    header('Location:singleOffer.php?id='.$insert);
} catch (PDOException $e) {
    echo 'Erreur :'.$e->getMessage().$e->getCode();
}