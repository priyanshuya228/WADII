<?php 
require('top.php');
if(!isset($_SESSION['USER_LOGIN'])){
	?>
	<script>
	window.location.href='index.php';
	</script>
	<?php
}
?>

<style>

.wishlist-content{
    margin-left:50px;
}

/* Style for the wishlist cards */
.wishlist-cards {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

/* Style for each wishlist card */
.wishlist-card {
    border: 1px solid #ddd;
    padding: 10px;
    width: 100%;
    max-width: 250px;
}

/* Style for the card header */
.wishlist-card-header a {
    font-weight: bold;
    text-decoration: none;
    color: #333;
    display: block;
    margin-bottom: 10px;
}

/* Style for item labels and values */
.item-label {
    font-weight: bold;
    margin-right: 5px;
}

.item-value {
    display: block;
    margin-bottom: 10px;
}

/* Style for the card content */
.wishlist-card-content {
    font-size: 14px;
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
                            $res = mysqli_query($conn, "select `order`.*, order_status.name as order_status_str from `order`, order_status where `order`.user_id='$uid' and order_status.id=`order`.order_status order by `order`.id desc");
                            while ($row = mysqli_fetch_assoc($res)) {
                            ?>
                            <div class="wishlist-card">
                                <div class="wishlist-card-header">
                                    <a href="my_order_details.php?id=<?php echo $row['id']?>">Order #<?php echo $row['id']?></a>
                                </div>
                                <div class="wishlist-card-content">
                                    <div class="wishlist-card-item">
                                        <span class="item-label">Order Date:</span>
                                        <span class="item-value"><?php echo $row['added_on']?></span>
                                    </div>
                                    <div class="wishlist-card-item">
                                        <span class="item-label">Address:</span>
                                        <span class="item-value">
                                            <?php echo $row['address']?><br>
                                            <?php echo $row['city']?><br>
                                            <?php echo $row['pincode']?>
                                        </span>
                                    </div>
                                    <div class="wishlist-card-item">
                                        <span class="item-label">Payment Type:</span>
                                        <span class="item-value"><?php echo $row['payment_type']?></span>
                                    </div>
                                    <div class="wishlist-card-item">
                                        <span class="item-label">Payment Status:</span>
                                        <span class="item-value"><?php echo ucfirst($row['payment_status'])?></span>
                                    </div>
                                    <div class="wishlist-card-item">
                                        <span class="item-label">Order Status:</span>
                                        <span class="item-value"><?php echo $row['order_status_str']?></span>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

        
        						
<?php require('footer.php')?>        