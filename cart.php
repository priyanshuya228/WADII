<?php
require('top.php');
?>

<style>
    .card-body {
        padding: 1rem;
    }

    .card-title {
        font-size: 1rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .card-text {
        margin-bottom: 0.5rem;
    }

    .card-img {
        width: 140px;
        height: 140px;
        object-fit: cover;
    }

    .card {
        margin: 10px 0;
    }
    .img-link img{
        margin-top:20px;
    }

    .product-details {
        display: flex;
        align-items: center;
    }

    .product-price {
        flex: 1;
        font-weight: bold;
    }

    .product-quantity,
    .product-subtotal {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .btn__fr {
        background-color: #c43b68;
        color: #fff;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        }

    .quantity-input {
        width: 40px;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 3px;
        font-size: 14px;
        text-align: center;
    }

    .quantity-input:hover {
        border-color: #333; 
    }

    .quantity-input:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }
</style>

<div class="cart-main-area ptb--100 bg__white" style="background-image: url('media/background.jpg'); background-size: cover;">
    <div class="container">
        <div class="row" style="margin-left:250px;">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <form action="#">
                    <div class="row" style="margin-left:70px;">
                        <?php
                        if (isset($_SESSION['cart'])) {
                            foreach ($_SESSION['cart'] as $key => $val) {
                                $productArr = get_product($conn, '', '', $key);
                                $pname = $productArr[0]['name'];
                                $mrp = $productArr[0]['mrp'];
                                $price = $productArr[0]['price'];
                                $image = $productArr[0]['image'];
                                $qty = $val['qty'];
                                $product_url = 'product.php?id=' . $key;
                                ?>
                                <div class="col-12">
                                    <div class="card mb-3">
                                        <div class="row no-gutters">
                                            <div class="col-md-4">
                                                <a href="<?php echo $product_url ?>" class="img-link">
                                                    <img src="<?php echo PRODUCT_IMAGE_SITE_PATH . $image ?>"
                                                         class="card-img" alt="Product Image" width="130" height="140" />
                                                </a>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <h5 class="card-title">
                                                        <a href="<?php echo $product_url ?>"><?php echo $pname ?></a>
                                                    </h5>
                                                    <p class="card-text">Price: Rs.<?php echo $price ?></p>
                                                    <p class="card-text">
                                                        Quantity:
                                                        <input type="number" class="quantity-input" id="<?php echo $key ?>qty" value="<?php echo $qty ?>" />
                                                        <a href="javascript:void(0)" onclick="manage_cart('<?php echo $key ?>','update')">Update</a>
                                                    </p>

                                                    <p class="card-text">Total: Rs.
                                                        <?php echo number_format((float)$qty * (float)$price, 2, '.', '') ?>
                                                    </p>
                                                    <a href="javascript:void(0)"
                                                       onclick="manage_cart('<?php echo $key ?>','remove')"
                                                       class="btn btn__fr">Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            <?php }
                        } ?>
                    </div>
                </form>
                <div class="buttons-cart--inner">
                    <div class="buttons-cart">
                        <a href="<?php echo SITE_PATH ?>">Continue Shopping</a>
                    </div>
                    <div class="buttons-cart checkout--btn" style="margin-right:145px;">
                        <a href="checkout.php">Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- End Cart Main Area -->

<?php require('footer.php') ?>
