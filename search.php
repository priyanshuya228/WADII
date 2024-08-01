<?php 
require('top.php');
$str=mysqli_real_escape_string($conn,$_GET['str']);
if($str!=''){
	$get_product=get_product($conn,'','','',$str);
}else{
	?>
	<script>
	window.location.href='index.php';
	</script>
	<?php
}										
?>
<div class="body__overlay"></div>
        
        <!-- Start Product Grid -->
        <section class="htc__product__grid bg__white ptb--100" style="background-image: url('media/background.jpg'); background-size: cover;">
            <div class="container">
                <div class="row">
					<?php if(count($get_product)>0){?>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="htc__product__rightidebar">
                            <!-- Start Product View -->
                            <div class="row">
                                <div class="shop__grid__view__wrap">
                                    <div role="tabpanel" id="grid-view" class="single-grid-view tab-pane fade in active clearfix">
                                        <?php
										foreach($get_product as $list){
										?>
										<!-- Start Single Category -->
										<div class="col-md-4 col-lg-3 col-sm-4 col-xs-12">
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
													<h4><a href="product-details.html"><?php echo $list['name']?></a></h4>
													<ul class="fr__pro__prize">
														<li class="old__prize"><?php echo $list['mrp']?></li>
														<li><?php echo $list['price']?></li>
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
					<?php } else { 
						echo "Data not found";
					} ?>
                
				</div>
            </div>
        </section>
        <!-- End Product Grid -->
        <!-- End Banner Area -->
		<input type="hidden" id="qty" value="1"/>
<?php require('footer.php')?>        