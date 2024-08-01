<?php
require('connection.inc.php');
require('functions.inc.php');
if(!isset($_SESSION['USER_LOGIN'])){
	?>
	<script>
	window.location.href='index.php';
	</script>
	<?php
}
$email=get_safe_value($conn,$_POST['email']);
$uid=$_SESSION['USER_ID'];
mysqli_query($conn,"update users set email='$email' where id='$uid'");
$_SESSION['USER_EMAIL']=$email;
echo "Your email is updated !";
?>