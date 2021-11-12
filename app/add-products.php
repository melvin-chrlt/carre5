<?php

$auth = true;
require 'includes/config.php';
include_once "_head.php";
include_once "_navbar.php";

if (isset($_GET["error"])) {
    $alert = true;
    if ($_GET['error'] == "missingInput") {
        $type = "secondary";
        $message = "Les champs requis sont vides";
    }
    if ($_GET['error'] == "pastDlc") {
        $type = "secondary";
        $message = "La date limite de consommation du produit est trop proche.";
    }
    if ($_GET['error'] == "unknownError") {
        $type = "warning";
        $message = "Une erreur s'est produite, réessayer ultérieurement.";
    }
}
?>

<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ps ps--active-y">
    <form action="add-products_post.php" method="post" class="container">
        <?php echo $alert ? "<div class='alert alert-{$type} mt-2'>{$message}</div>" : ''; ?>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Nom du produit</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="CARRE5 xxxx" name="name"
                required>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Description</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description"
                required></textarea>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Prix du produit</label>
            <input type="number" min="0.01" step="0.01" class="form-control" id="exampleFormControlInput1"
                placeholder="125" name="price" required>
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Image du produit</label>
            <input class="form-control" type="file" id="formFile" name="image">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Date limite de consommation/d'usage optimal</label>
            <input type="date" class="form-control" id="exampleFormControlInput1" placeholder="01-01-2050" name="dlc">
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-outline-success btn-lg">Ajouter produit</button>
        </div>

    </form>

</main>









<?php
/**
 * ! Etapes logiques de l'ajout de produits (Front)
 * 
 * TODO : Vérifier la base de données pour les champs nécessaires
 * 
 * TODO : Construire un formulaire approprié (par raport à l'étape précédente)
 * 
 * TODO : Ne pas oublier la récupération des données liées au formulaire depuis la base de données. (Une fois l'ajout de catégories)
 */