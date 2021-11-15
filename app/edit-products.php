<?php

$auth = true;
require 'includes/config.php';
require 'includes/connect.php';
include_once '_head.php';
include_once '_navbar.php';

include_once '_view-single.php';

?>

<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ps ps--active-y">
    <div class="card container m-4 p-4">

        <!-- Afin de passer de l'affichage à l'édit, on a rajouté une balise form et modifié l'ensemble de nos champs
        affichés en inputs correspondant à leur types (input type text, type number, type file, type date et
        textarea) -->
        <form action="edit-products_post.php" method="post" enctype="multipart/form-data">
            <input type="text" class="form-control form-control-lg" name="name"
                value="<?php echo $product['name']; ?>"></input>
            <div class="col-md-4 center">
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="img-fluid">
            </div>
            <p class="text-bold">Description :</p>
            <textarea name="description" class="form-control" rows=3><?php echo $product['description']; ?></textarea>
            <hr>
            <p class="text-bold">Date limite de consommation :</p>
            <input type="date" class="form-control" name="dlc" value="<?php echo $product['dlc']; ?>" />
            <hr>
            <p class="text-bold">Prix :</p>
            <input type="number" class="form-control col-2 mb-2" name="price"
                value="<?php echo $product['price']; ?>" />
            <input type="hidden" name="id" value="<?php echo $product['product_id']; ?>">
            <button type="submit" class="btn btn-warning col-2">Modifier
                article</button>
        </form>
    </div>
    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
        <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
    </div>
    <div class="ps__rail-y" style="top: 0px; height: 600px; right: 0px;">
        <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 333px;"></div>
    </div>
</main>

<?php

include_once '_footer.php';
?>