<?php 
require('top.php');
if(!isset($_SESSION['USER_LOGIN'])){
	?>
	<script>
	window.location.href='index.php';
	</script>
	<?php
}
$order_id=get_safe_value($conn,$_GET['id']);
?>

<style>
/* Style for the wishlist cards */
.wishlist-cards {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

/* Style for each wishlist card */
.wishlist-card {
    border: 1px solid #ddd;
    width: 100%;
    max-width: 300px;
    display: flex;
    flex-direction: column;
}

.wishlist-card-image {
    margin-top:10px;
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}

.wishlist-card-item{
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    margin-left: 45px;
    margin-top:10px;
}

/* Style for item labels and values */
.item-label {
    font-weight: bold;
    margin-right: 5px;
}

.item-value {
    display: block;
}

/* Style for the total price section */
.total-price {
    font-weight: bold;
    text-align: right;
}



</style>

<div class="wishlist-area ptb--100 bg__white" style="background-image: url('media/background_2.jpg'); background-size: cover;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="wishlist-content">
                    <form action="#">
                        <div class="wishlist-cards">
                            <?php
                            $uid = $_SESSION['USER_ID'];
                            $res = mysqli_query($conn, "select distinct(order_detail.id), order_detail.*, product.name, product.image from order_detail, product, `order` where order_detail.order_id='$order_id' and `order`.user_id='$uid' and order_detail.product_id=product.id");
                            $total_price = 0;
                            while ($row = mysqli_fetch_assoc($res)) {
                                $total_price += $row['qty'] * $row['price'];
                            ?>
                                <div class="wishlist-card">
                                    <div class="wishlist-card-image">
                                        <img src="<?php echo PRODUCT_IMAGE_SITE_PATH . $row['image'] ?>" alt="Product Image" width="200px" height="250px" />
                                    </div>
                                    <div class="wishlist-card-content">
                                        <div class="wishlist-card-item">
                                            <span class="item-label">Product Name:</span>
                                            <span class="item-value"><?php echo $row['name'] ?></span>
                                        </div>
                                        <div class="wishlist-card-item">
                                            <span class="item-label">Quantity:</span>
                                            <span class="item-value"><?php echo $row['qty'] ?></span>
                                        </div>
                                        <div class="wishlist-card-item">
                                            <span class="item-label">Price:</span>
                                            <span class="item-value">Rs. <?php echo $row['price'] ?></span>
                                        </div>
                                        <div class="wishlist-card-item">
                                            <span class="item-label">Total Price:</span>
                                            <span class="item-value">Rs. <?php echo $row['qty'] * $row['price'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="total-price">
                            <span class="item-label">Total Price:</span>
                            <span class="item-value">Rs. <?php echo $total_price ?></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

        
        						
<?php require('footer.php')?>        