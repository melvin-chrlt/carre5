<?php
$auth = true;
    require '_head.php';
    require '_navbar.php';
    require '_sqlfetchCategories.php';
    require '_sqlFetchSingle.php';
    
?>

<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ps ps--active-y">
    <form action="editOffer_post.php" method="post" class="container" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Name *</label>
            <input type="text" class="form-control" id="type" name="name" value="<?php echo $offer['name']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" rows="3" name="description" required><?php echo $offer['description']?></textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price *</label>
            <input type="number" class="form-control" id="price" name="price" value="<?php echo $offer['price'];?>" required>
        </div>
        <div class="mb-3">
            <label for="dlc" class="form-label">DLC *</label>
            <input placeholder="Select date" type="date" id="dlc" class="form-control" name="dlc" value="<?php echo $offer['dlc'];?>">
        </div>
        <!-- <div class="mb-3">
            <label for="formFile" class="form-label">Image</label>
            <input type="file" id="image" class="form-control" name="image" accept="image/jpg, image/jpeg, image/png, image/gif" value="<?php echo $offer['image'];?>">
        </div> -->
        <input type="hidden" name="product_id" value="<?php echo $offer['product_id']; ?>">
        <div class="mb-3">
            <button type="submit" class="btn btn-outline-success btn-lg">Edit offer</button>
        </div>

    </form>

</main>

<?php require '_footer.php'; ?>

<?php

/**
 * ! ETAPES LOGIQUES DE LA CREATION D'ITEMS.
 *
 * TODO : Vérifier que le formulaire est approprié (typage, présence du name...)
 * TODO : Vérifier la présence des inputs nécessaires
 * TODO : Vérifier la validité des inputs pour l'inclusion dans la BDD
 * TODO : Vérifier la base de données pour la possibilité d'inclusion (si le produit existe déja, ce ne sera pas nécessaire pour ce projet)
 * TODO : Récupérer les données après introduction (pour vérification)
 */
?>