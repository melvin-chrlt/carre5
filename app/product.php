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
        <h3><?php echo $product['name']; ?></h3>
        <div class="col-md-4 center">
            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="img-fluid">
        </div>
        <p class="text-bold">Description :</p>
        <p><?php echo $product['description']; ?></p>
        <hr>
        <p class="text-bold">Date limite de consommation :</p>
        <p><?php echo $product['dlc']; ?></p>
        <hr>
        <p class="btn btn-success col-2"><?php echo $product['price']; ?>€</p>
        <a href="edit-products.php?id=<?php echo $product['product_id']; ?>" class="btn btn-warning col-2">Modifier
            article</a>
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