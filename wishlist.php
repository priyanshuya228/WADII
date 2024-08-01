<?php 
require('top.php');
if(!isset($_SESSION['USER_LOGIN'])){
	?>
	<script>
	window.location.href='index.php';
	</script>
	<?php
}
$uid=$_SESSION['USER_ID'];

$res=mysqli_query($conn,"select product.name,product.id as pid,product.image,product.price,product.mrp,wishlist.id from product,wishlist where wishlist.product_id=product.id and wishlist.user_id='$uid'");
?>
<style>
    /* Style for the product list */
    .product-list {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    /* Style for each product */
    .product {
        display: flex;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        padding: 10px;
    }

    /* Style for the product thumbnail */
    .product-thumbnail {
        margin-right: 20px;
    }

    .product-thumbnail img {
        max-width: 130px;
        max-height: 140px;
    }

    /* Style for the product details */
    .product-details {
        flex: 1;
    }

    /* Style for the product name */
    .product-name a {
        font-weight: bold;
        text-decoration: none;
        color: #333;
    }

    /* Style for the price and old price */
    .pro__prize li {
        display: inline;
        margin-right: 10px;
    }

    .product-actions{
        margin-top: 40px;
    }

    /* Style for product actions */
    .product-actions a {
        text-decoration: none;
        color: #555;
        margin-right: 10px;
    }

    /* Style for buttons cart */
    .buttons-cart--inner {
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
    }

    .buttons-cart a {
        display: inline-block;
        background-color: #333;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
    }

    .buttons-cart a:hover {
        background-color: #c43b68;
    }

</style>
<div class="cart-main-area ptb--100 bg__white" style="background-image: url('media/background.jpg'); background-size: cover;" >
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <form action="#">
                    <div class="product-list">
                        <?php
                        while ($row = mysqli_fetch_assoc($res)) {
                            $product_url = 'product.php?id=' . $row['pid'];
                            ?>

                            <div class="product">
                                <div class="product-thumbnail">
                                    <a href="<?php echo $product_url ?>">
                                        <img src="<?php echo PRODUCT_IMAGE_SITE_PATH . $row['image'] ?>" width="130px" height="140px" />
                                    </a>
                                </div>
                                <div class="product-details">
                                    <div class="product-name">
                                        <a href="<?php echo $product_url ?>"><?php echo $row['name'] ?></a>
                                    </div>
                                    <ul class="pro__prize">
                                        <li>Rs.<?php echo $row['price'] ?></li>&nbsp;&nbsp;&nbsp;
                                        <li class="old__prize"><strike>Rs.<?php echo $row['mrp'] ?></strike></li>
                                    </ul>
                                    <div class="product-actions">
                                        <a href="wishlist.php?wishlist_id=<?php echo $row['id']?>"><i class="icon-trash icons"></i></a>
                                        <a href="javascript:void(0)" onclick="manage_cart('<?php echo $row['pid']?>','add')">
                                        Add to Cart
                                        </a>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>
                    </div>
                </form>
                <div class="buttons-cart--inner">
                    <div class="buttons-cart">
                        <a href="<?php echo SITE_PATH?>">Continue Shopping</a>
                    </div>
                    <div class="buttons-cart checkout--btn">
                        <a href="<?php echo SITE_PATH?>checkout.php">Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        
										
<?php require('footer.php')?>        