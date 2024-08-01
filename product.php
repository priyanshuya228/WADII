<?php 
ob_start();
require('top.php');
if(isset($_GET['id'])){
    $product_id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT added_by FROM product WHERE id = $product_id";
    $res = mysqli_query($conn, $query);
    if ($res) {
        $row = mysqli_fetch_assoc($res);
        $seller_id = $row['added_by'];
    }
    $seller_name_query = "SELECT username FROM admin_users WHERE id = $seller_id";
    $seller_name_res = mysqli_query($conn, $seller_name_query);
    if ($seller_name_res) {
        $seller_name_row = mysqli_fetch_assoc($seller_name_res);
        $seller_name = $seller_name_row['username'];
    }
    // Function to check if the seller has completed 5 successful orders
    function hasCompleted5Orders($conn, $seller_id) {
        $query = "SELECT COUNT(DISTINCT o.id) AS order_count
                  FROM `order` AS o
                  INNER JOIN order_detail AS od ON o.id = od.order_id
                  INNER JOIN product AS p ON od.product_id = p.id
                  WHERE p.added_by = $seller_id
                  AND o.order_status = 5"; 
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $orderCount = $row['order_count'];

        return $orderCount >= 5;
    }

    // Checking if the seller has completed 5 successful orders
    if (hasCompleted5Orders($conn, $seller_id)) {
        $validationMarker = '<span class="validation-marker"><img src="media/verification_badge.png"> </span>';
    } else {
        $validationMarker = '';
    }
	if($product_id>0){
		$get_product=get_product($conn,'','',$product_id);
	}else{
		?>
		<script>
		window.location.href='index.php';
		</script>
		<?php
	}
}else{
	?>
	<script>
	window.location.href='index.php';
	</script>
	<?php
}
if(isset($_POST['review_submit'])){
	$rating=get_safe_value($conn,$_POST['rating']);
	$review=get_safe_value($conn,$_POST['review']);
	
	$added_on=date('Y-m-d h:i:s');
	mysqli_query($conn,"insert into product_review(product_id,user_id,rating,review,status,added_on) values('$product_id','".$_SESSION['USER_ID']."','$rating','$review','1','$added_on')");
    echo "
	<script>
	window.location.href='product.php?id='+'$product_id';
	</script>
    ";
    die();
}


$product_review_res=mysqli_query($conn,"select users.name,product_review.id,product_review.rating,product_review.review,product_review.added_on from users,product_review where product_review.status=1 and product_review.user_id=users.id and product_review.product_id='$product_id' order by product_review.added_on desc");

?>

        <section class="htc__product__details bg__white ptb--100" style="background-image: url('media/background.jpg'); background-size: cover;">
            <div class="htc__product__details__top">
                <div class="container">
                    <div class="row">
                        <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
                            <div class="htc__product__details__tab__content">
                                <div class="product__big__images">
                                    <div class="portfolio-full-image tab-content">
                                        <div role="tabpanel" class="tab-pane fade in active" id="img-tab-1">
                                            <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$get_product['0']['image']?>">
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-md-7 col-lg-7 col-sm-12 col-xs-12 smt-40 xmt-40">
                            <div class="ht__product__dtl">
                                <h2><?php echo $get_product['0']['name']?></h2>
                                <ul  class="pro__prize">
                                    <li>Rs.<?php echo $get_product['0']['price']?></li>&nbsp;&nbsp;&nbsp;
                                    <li class="old__prize"><strike>Rs.<?php echo $get_product['0']['mrp']?></strike></li>
                                </ul>
    
                                <p class="pro__info">Sold by : <?php echo $seller_name; ?><?php echo $validationMarker; ?></p>

                                <p class="pro__info"><?php echo $get_product['0']['short_desc']?></p>
                                <div class="ht__pro__desc">
                                    <div class="sin__desc">
                                        <p><span>Availability:</span> In Stock</p>
                                    </div>
                                    <div class="sin__desc align--left">
                                        <p><span>Categories:</span></p>
                                        <ul class="pro__cat__list">
                                            <li><a href="#"><?php echo $get_product['0']['categories']?></a></li>
                                        </ul>
                                    </div>
                                    
                                    </div>
									
                                </div>
								<br>

								<a class="fr__btn" href="javascript:void(0)" onclick="manage_cart('<?php echo $get_product['0']['id']?>','add')">Add to cart</a>
								
								<?php if(isset($_SESSION['USER_LOGIN'])){ ?>

                                <a class="fr__btn" href='chat.php?outgoing_msg_id=<?php echo $_SESSION["USER_ID"]; ?>&incoming_msg_id=<?php echo $seller_id; ?>&pid=<?php echo $product_id; ?>'>Contact Seller</a>
								<?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


		<section class="htc__produc__decription bg__white" style="background-image: url('media/background.jpg'); background-size: cover;">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="ht__pro__details__content">
                    <!-- Product Description -->
					<h2>Description</h2>
					<br>
                    <div class="pro__single__content">
                        <div class="pro__tab__content__inner">
                            <?php echo $get_product['0']['description']?>
                        </div>
                    </div>
					<br><br><br>
                    <!-- Product Reviews -->
					<h2>Reviews and Ratings</h2>
					<br>
                    <div class="pro__single__content">
                        <div class="pro__tab__content__inner">
                            <?php 
                            if (mysqli_num_rows($product_review_res) > 0) {
                                while ($product_review_row = mysqli_fetch_assoc($product_review_res)) {
                            ?>
                                <article class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="panel panel-default arrow left">
                                            <div class="panel-body">
                                                <header class="text-left">
                                                    <div>
                                                        <span class="comment-rating"> <?php echo $product_review_row['rating']?></span> <br>
                                                        (added by <b><?php echo $product_review_row['name']?></b> on
                                                        <time class="comment-date"> 
                                                        <?php
                                                        $added_on = strtotime($product_review_row['added_on']);
                                                        echo date('d M Y', $added_on);
                                                        ?>
                                                    </time>)
                                                    </div>
                                                </header>
                                                <div class="comment-post">
                                                    <p>
                                                        <?php echo $product_review_row['review']?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            <?php } } else { 
                                echo "<h3 class='submit_review_hint'>No review added</h3><br/>";
                            }
                            ?>

                            <h3 class="review_heading">Enter your review</h3><br/>
                            <?php
                            if (isset($_SESSION['USER_LOGIN'])) {
                            ?>
                                <div class="row" id="post-review-box" style=>
                                    <div class="col-md-12">
                                        <form action="" method="post">
                                            <select class="form-control" name="rating" required>
                                                <option value="">Select Rating</option>
                                                <option>&#9733;</option>
                                                <option>&#9733;&#9733;</option>
                                                <option>&#9733;&#9733;&#9733;</option>
                                                <option>&#9733;&#9733;&#9733;&#9733;</option>
                                                <option>&#9733;&#9733;&#9733;&#9733;&#9733;</option>
                                            </select>    <br/>
                                            <textarea class="form-control" cols="50" id="new-review" name="review" placeholder="Enter your review here..." rows="5"></textarea>
											<br>
                                            <div class="text-left mt10">
                                                <button class="btn btn-lg" type="submit" name="review_submit">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php } else {
                                echo "<span class='submit_review_hint'>Please <a href='login.php'>login</a> to submit your review</span>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

		<?php
		if(isset($_COOKIE['recently_viewed'])){
			$arrRecentView=unserialize($_COOKIE['recently_viewed']);
			$countRecentView=count($arrRecentView);
			$countStartRecentView=$countRecentView-4;
			if($countStartRecentView>4){
				$arrRecentView=array_slice($arrRecentView,$countStartRecentView,4);
			}
			$recentViewId=implode(",",$arrRecentView);
			$res=mysqli_query($conn,"select * from product where id IN ($recentViewId) and status=1");
			
		?>
		<section class="htc__produc__decription bg__white" style="background-image: url('media/background.jpg'); background-size: cover;">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h2>Recently Viewed</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="ht__pro__details__content">
                            <div class="row">
								<?php while($list=mysqli_fetch_assoc($res)){?>
								<div class="col-xs-3">
									<div class="category">
												<div class="ht__cat__thumb">
													<a href="product.php?id=<?php echo $list['id']?>">
														<img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$list['image']?>" alt="product images" width="550px" height="300px">
													</a>
												</div>
												<div class="fr__hover__info">
													<ul class="product__action">
														<li><a href="javascript:void(0)" onclick="wishlist_manage('<?php echo $list['id']?>','add')"><i class="icon-heart icons"></i></a></li>
														<li><a href="javascript:void(0)" onclick="manage_cart('<?php echo $list['id']?>','add')"><i class="icon-handbag icons"></i></a></li>
													</ul>
												</div>
												<div class="fr__product__inner">
													<h4><a href="product.php?id=<?php echo $list['id']?>"><?php echo $list['name']?></a></h4>
													<ul class="fr__pro__prize">
														<li class="new__price">Rs.<?php echo $list['price']?></li>
														<li class="old__prize"><strike>Rs.<?php echo $list['mrp']?></strike></li>
													</ul>
												</div>
											</div>	
								    </div>
								<?php } ?>
							    </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
		<?php 
			$arrRec=unserialize($_COOKIE['recently_viewed']);
			if(($key=array_search($product_id,$arrRec))!==false){
				unset($arrRec[$key]);
			}
			$arrRec[]=$product_id;
		}else{
			$arrRec[]=$product_id;
		}
		setcookie('recently_viewed',serialize($arrRec),time()+60*60*24*365);
		?>
								
<?php 
require('footer.php');
ob_flush();
?>        