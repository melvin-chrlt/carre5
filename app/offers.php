<?php
    $auth = true;
    require '_head.php';
    require '_navbar.php';
    require '_sqlFetchOffers.php';
?>
<div class="container d-flex flex-wrap" style="width:70%">
    <?php if (!empty($offers)) {
        foreach ($offers as $offer) { ?>
    <div class="card m-4 mx-auto" style="width:30%;">
        <div class="card-body">
        <!-- <img src="<?php echo $offer['image']; ?>" title="Image de <?php echo $offer['name']; ?>" alt="Image de <?php echo $offer['name']; ?>"> -->
            <h3 class="card-title"><?php echo $offer['name']; ?></h3>
            <h6 class="card-title"><?php echo $offer['description']; ?></h6>
            <p>Price : <?php echo $offer['price']; ?> €</p>
            <hr>
            <div class="d-flex justify-content-around align-items-center">
            <form action="deleteOffer_post.php" method="post">
                <input type="hidden" name="product_id" value="<?php echo $offer['product_id']; ?>">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['token']; ?>">
                <input type="submit" class="form-control btn btn-danger col-4" value="Delete offer" />
            </form>
            <a href="#" class="btn btn-success col-5">Ajouter au panier</a>
        </div>
        </div>
    </div>
    <?php }
    } else { ?>
    <div class="container mt-4 text-center bg-secondary p-2 " style="--bs-bg-opacity: .25">
        <h3>No products available right now, come back soon !</h3>
    </div>
    <?php } ?>
</div>


<?php require '_footer.php'; ?>