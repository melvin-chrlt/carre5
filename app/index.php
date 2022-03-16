<?php

include_once '_head.php';
include_once '_navbar.php';
require '_sqlFetchOffers.php';

?>

<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ps ps--active-y">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
        navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <h6 class="font-weight-bolder mb-0">Tables</h6>
            </nav>
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                    <div class="input-group">
                        <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" placeholder="Type here...">
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Table des produits</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Image</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nom</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Description</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Prix</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">DLC</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($offers)) { ?>
                                    <?php foreach ($offers as $offer) { ?>
                                    <tr>
                                        <td>
                                            <img src="<?php echo $offer['image']; ?>" title="Image de <?php echo $offer['name']; ?>" alt="Image de <?php echo $offer['name']; ?>">
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"><?php echo $offer['name']; ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"><?php echo $offer['description']; ?></h6></p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"><?php echo $offer['price']; ?>€</h6></p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold"><?php echo $offer['dlc']; ?></span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="singleOffer.php?id= <?php echo $offer['product_id']?>"
                                                class="text-secondary font-weight-bold text-xs text-primary mx-1"
                                                data-toggle="tooltip" data-original-title="Show product">
                                                Show</a>
                                            <?php if (!empty($_SESSION)) { ?>
                                            <a href="editOffer.php?id= <?php echo $offer['product_id']?>" class="text-secondary font-weight-bold text-xs mx-1"
                                                data-toggle="tooltip" data-original-title="Edit product">
                                                Edit</a>
                                            <form action="deleteOffer_post.php" method="post">
                                                <input type="hidden" name="product_id" value="<?php echo $offer['product_id']; ?>">
                                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['token']; ?>">
                                                <input type="submit" class="form-control btn btn-sm btn-danger col-4" value="Delete offer" style="width:80%"/>
                                            </form>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
