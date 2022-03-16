<?php
$auth = true;
    require '_head.php';
    require '_navbar.php';
    require '_sqlFetchSingle.php';
?>
<?php if (!empty($offer)) {?>
<div class="card m-4 mx-auto" style="width:30%;">
    <div class="card-body">
        <img src="<?php echo $offer['image']; ?>" title="Image de <?php echo $offer['name']; ?>" alt="Image de <?php echo $offer['name']; ?>">
        <h3 class="card-title"><?php echo $offer['name']; ?></h3>
        <p>Price : <?php echo $offer['price']; ?>€</p>
        <hr>
        <p>Description : <?php echo $offer['description']; ?></p>
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
<?php
} else {
    //header('Location:offers.php?error=notFound');
}

require '_footer.php'; ?>