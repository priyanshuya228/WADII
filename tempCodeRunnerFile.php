<section class="htc__produc__decription bg__white">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h3 style="font-size: 20px; font-weight: bold;">Recently Viewed</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="ht__pro__details__content">
                    <div class="row">
                        <?php
                        $arrRecentView = isset($_COOKIE['recently_viewed']) ? unserialize($_COOKIE['recently_viewed']) : array();
                        if (!empty($arrRecentView)) {
                            $countRecentView = count($arrRecentView);
                            $countStartRecentView = $countRecentView - 4;
                            if ($countStartRecentView < 0) {
                                $countStartRecentView = 0;
                            }
                            $recentViewId = implode(",", $arrRecentView);
                            echo "Recent View IDs: " . $recentViewId;

                            $recentViewRes = mysqli_query($conn, "SELECT * FROM product WHERE id IN ($recentViewId) AND status=1");
                            while ($list = mysqli_fetch_assoc($recentViewRes)) {
                                ?>
                                <div class="col-xs-3">
                                    <div class="category">
                                        <div class="ht__cat__thumb">
                                            <a href="product.php?id=<?php echo $list['id'] ?>">
                                                <img src="<?php echo PRODUCT_IMAGE_SITE_PATH . $list['image'] ?>"
                                                     alt="product images">
                                            </a>
                                        </div>
                                        <div class="fr__hover__info">
                                            <ul class="product__action">
                                                <li><a href="javascript:void(0)"
                                                       onclick="wishlist_manage('<?php echo $list['id'] ?>','add')"><i
                                                                class="icon-heart icons"></i></a></li>
                                                <li><a href="javascript:void(0)"
                                                       onclick="manage_cart('<?php echo $list['id'] ?>','add')"><i
                                                                class="icon-handbag icons"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="fr__product__inner">
                                            <h4><a href="product-details.html"><?php echo $list['name'] ?></a></h4>
                                            <ul class="fr__pro__prize">
                                                <li class="old__prize"><?php echo $list['mrp'] ?></li>
                                                <li><?php echo $list['price'] ?></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php

if (!in_array($product_id, $arrRecentView)) {
    $arrRecentView[] = $product_id;
    if (count($arrRecentView) > 4) {
        array_shift($arrRecentView); 
    }
    setcookie('recently_viewed', serialize($arrRecentView), time() + 60 * 60 * 24 * 365, '/');
}
?>