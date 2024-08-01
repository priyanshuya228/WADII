<?php
require('connection.inc.php');
require('functions.inc.php');
require('add_to_cart.inc.php');
$wishlist_count=0;
$cat_res=mysqli_query($conn,"select * from categories where status=1 order by categories asc");
$cat_arr=array();
while($row=mysqli_fetch_assoc($cat_res)){
	$cat_arr[]=$row;	
}

$obj=new add_to_cart();
$totalProduct=$obj->totalProduct();

if(isset($_SESSION['USER_LOGIN'])){
	$uid=$_SESSION['USER_ID'];
	
	if(isset($_GET['wishlist_id'])){
		$wid=get_safe_value($conn,$_GET['wishlist_id']);
		mysqli_query($conn,"delete from wishlist where id='$wid' and user_id='$uid'");
	}
    
	$wishlist_count=mysqli_num_rows(mysqli_query($conn,"select product.name,product.image,product.price,product.mrp,wishlist.id from product,wishlist where wishlist.product_id=product.id and wishlist.user_id='$uid'"));
}
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Craftopia</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/core.css">
    <link rel="stylesheet" href="css/shortcode/shortcodes.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
	<script src="js/vendor/modernizr-3.5.0.min.js"></script>

	<style>
        .htc__shopping__cart{
            margin-left: 20px;
        }
        .htc__shopping__cart a span.htc__wishlist {
            background: #c43b68;
            border-radius: 100%;
            color: #fff;
            font-size: 9px;
            height: 17px;
            line-height: 19px;
            position: absolute;
            right: 18px;
            text-align: center;
            top: -4px;
            width: 17px;
        }
        .fr__btn {
            background-color: #c43b68;
            color: #fff; 
            padding: 10px 20px;
            border: none;
            border-radius: 5px; 
            cursor: pointer; 
            font-size: 16px; 
        }

        .fr__btn:hover {
            background-color: black; 
        }

        .htc__select__option {
            position: relative;
            display: inline-block;
            background-color: #fff;
        }

        .ht__select {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #fff;
            color: #333;
            appearance: none; 
            -webkit-appearance: none; 
        }

        .ht__select:focus {
            outline: none;
            border-color: #999;
        }

        .ht__select::before {
            content: '▼';
            color: #999;
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .ht__select option:hover {
            background-color: #c43b68 !important;
            color: #fff; 
        }

        .pro__info{
            font-size: 40px;
            color:blue;
        }
        .validation-marker img{
            width: 10px;
            height: 10px;
            margin-left: 5px;
            margin-bottom: 10px;
        }

        .accordion {
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            margin: 10px;
            padding: 10px;
        }

        .accordion__header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            cursor: pointer;
        }

        .accordion__body {
            padding: 10px;
        }

        .single-input {
            margin-bottom: 10px;
        }

        input[type="radio"] {
            margin-right: 5px;
        }

        .single-method {
            margin-bottom: 10px;
        }

        input[name="address"],
        input[name="city"],
        input[name="pincode"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
        }
  
        .accordion__body + .accordion__header {
            margin-top: 10px;
        }

        .slider {
            display: flex;
            overflow: hidden;
            width: 100%;
        }

        .slide {
            flex: 0 0 100%;
        }

        .flex_slider_item {
            max-width: 100%;
            height: auto;
        }

        .slick-prev, .slick-next {
            background-color: #c43b68;
            color: black;
            display:flex;
            align-items:center;
            justify-content:center;
            text-align:center;
            transform:scale(1.5);
            width: 10px;
            padding: 20px 30px;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            cursor: pointer;
            border-radius: 50px;
        }

        .slick-prev{
            margin-left:10px;
        }
        .slick-next{
            margin-right:10px;
        }

        .slick-prev:hover, .slick-next:hover{
            background-color: black;
            color: white;
        }


	</style>
</head>
<body>

    <div class="wrapper">
        <header id="htc__header" class="htc__header__area header--one">
        <div id="sticky-header-with-topbar" class="mainmenu__wrap sticky__header">
            <div class="container">
                <div class="row">
                    <div class="menumenu__container clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-5"> 
                            <div class="logo">
                                <a href="index.php"><h1>Craftopia</h1></a>
                            </div>
                        </div>
                        <div class="col-md-7 col-lg-6 col-sm-5 col-xs-3">
                            <nav class="main__menu__nav hidden-xs hidden-sm">
                                <ul class="main__menu">
                                    <li class="drop"><a href="index.php">Home</a></li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Categories <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <?php
                                            foreach ($cat_arr as $list) {
                                                ?>
                                                <li><a href="categories.php?id=<?php echo $list['id'] ?>"><?php echo $list['categories'] ?></a></li>
                                                <?php
                                            }
                                            ?>
                                            
                                        </ul>
                                    </li>
                                    <li><a href="contact.php">Contact</a></li>
                                    <li><a href="learning_platform/home.php">Learn</a></li>
                                    <?php
                                    if(isset($_SESSION['USER_LOGIN'])){
                                        echo '<li><a href="all_chats.php">Chats</a></li>' ;
                                    }
                                    ?>
                                </ul>
                            </nav>

                            <div class="mobile-menu clearfix visible-xs visible-sm">
                                <nav id="mobile_dropdown">
                                    <ul>
                                        <li><a href="index.php">Home</a></li>
                                        <li class="dropdown-submenu">
                                            <a href="#">Categories</a>
                                            <ul class="dropdown-menu">
                                                <?php
                                                foreach($cat_arr as $list){
                                                    ?>
                                                    <li><a href="categories.php?id=<?php echo $list['id']?>"><?php echo $list['categories']?></a></li>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </li>
                                        <li><a href="contact.php">contact</a></li>
                                        <?php
                                        if(isset($_SESSION['USER_LOGIN'])){
                                            echo '<li><a href="all_chats.php">Chats</a></li>' ;
                                        }
                                        ?>
                                        <li><a href="learning_platform/home.php">Learn</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-4 col-sm-4 col-xs-4">
                            <div class="header__right">
                                <div class="header__search search search__open">
                                    <a href="#"><i class="icon-magnifier icons"></i></a>
                                </div>
                                <div class="header__account">
                                    <?php
                                    if (isset($_SESSION['USER_LOGIN'])) {
                                        echo '
                                        <div class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                                My Account
                                                <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu">
                                            <li><a href="update_details.php">Personal Details</a></li>
                                                <li><a href="my_order.php">Orders</a></li>
                                                <li><a href="logout.php">Logout</a></li>
                                            </ul>
                                        </div>
                                        ';
                                    } else {
                                        echo '<a href="login.php">Login/Register</a>';
                                    }
                                    ?>
                                </div>
                                <div class="htc__shopping__cart">
                                    <?php
                                    if (isset($_SESSION['USER_ID'])) {
                                    ?>
                                        <a href="wishlist.php"><i class="icon-heart icons"></i></a>
                                        <a href="wishlist.php"><span class="htc__wishlist"><?php echo $wishlist_count ?></span></a>
                                    <?php } ?>
                                    <a href="cart.php"><i class="icon-handbag icons"></i></a>
                                    <a href="cart.php"><span class="htc__qua"><?php echo $totalProduct ?></span></a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="mobile-menu-area"></div>
            </div>
        </div>


        </header>
		<div class="body__overlay"></div>
		<div class="offset__wrapper">
            <div class="search__area">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="search__inner">
                                <form action="search.php" method="get">
                                    <input placeholder="Search for a product here  " type="text" name="str">
                                    <button type="submit"></button>
                                </form>
                                <div class="search__close__btn">
                                    <span class="search__close__btn_icon"><i class="zmdi zmdi-close"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<hr style="height:10px">