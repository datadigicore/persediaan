<?php
include ('config/app.php');
if ($_SESSION['level']==1) {
	header('location:admin/index');
}
else if ($_SESSION['level']==2) {
	header('location:user/index');
}
else {
	header('location:login');
}
?>