<?php
require('connection.inc.php');
require('functions.inc.php');
require('add_to_cart.inc.php');

$pid=get_safe_value($conn,$_POST['pid']);
$type=get_safe_value($conn,$_POST['type']);

if(isset($_SESSION['USER_LOGIN'])){
	$uid=$_SESSION['USER_ID'];
	if(mysqli_num_rows(mysqli_query($conn,"select * from wishlist where user_id='$uid' and product_id='$pid'"))>0){
	}else{

		wishlist_add($conn,$uid,$pid);
	}
	echo $total_record=mysqli_num_rows(mysqli_query($conn,"select * from wishlist where user_id='$uid'"));
}else{
	$_SESSION['WISHLIST_ID']=$pid;
	echo "not_login";
}
?>