<?php 
require('top.php');

if(!isset($_GET['id']) && $_GET['id']!=''){
	?>
	<script>
	window.location.href='index.php';
	</script>
	<?php
}

$cat_id=mysqli_real_escape_string($conn,$_GET['id']);

$price_high_selected="";
$price_low_selected="";
$new_selected="";
$old_selected="";
$sort_order="";
if(isset($_GET['sort'])){
	$sort=mysqli_real_escape_string($conn,$_GET['sort']);
	if($sort=="price_high"){
		$sort_order=" order by product.price desc ";
		$price_high_selected="selected";	
	}if($sort=="price_low"){
		$sort_order=" order by product.price asc ";
		$price_low_selected="selected";
	}if($sort=="new"){
		$sort_order=" order by product.id desc ";
		$new_selected="selected";
	}if($sort=="old"){
		$sort_order=" order by product.id asc ";
		$old_selected="selected";
	}
}

if($cat_id>0){
	$get_product=get_product($conn,'',$cat_id,'','',$sort_order);
}else{
	?>
	<script>
	window.location.href='index.php';
	</script>
	<?php
}										
?>
<div class="body__overlay"></div>
        
        <section class="htc__product__grid bg__white ptb--100" style="background-image: url('media/background.jpg'); background-size: cover;">
            <div class="container">
                <div class="row">
					<?php if(count($get_product)>0){?>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="htc__product__rightidebar">
                            <div class="htc__grid__top">
                                <div class="htc__select__option">
                                    <select class="ht__select" onchange="sort_product_drop('<?php echo $cat_id?>','<?php echo SITE_PATH?>')" id="sort_product_id">
                                        <option value=""><b> Sort by &nbsp; &nbsp; &nbsp; &nbsp; &#8595;</b></option>
                                        <option value="price_low" <?php echo $price_low_selected?>>Price low to high</option>
                                        <option value="price_high" <?php echo $price_high_selected?>>Price high to low</option>
                                        <option value="new" <?php echo $new_selected?>>Newest first</option>
										<option value="old" <?php echo $old_selected?>>Oldest first</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="shop__grid__view__wrap">
                                    <div role="tabpanel" id="grid-view" class="single-grid-view tab-pane fade in active clearfix">
                                        <?php
										foreach($get_product as $list){
										?>
			
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
														<li>Rs.<?php echo $list['price']?></li>
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
					<?php } ?>
                
				</div>
            </div>
        </section>
		<input type="hidden" id="qty" value="1"/>
<?php require('footer.php')?>        