<?php
include ('config/app.php');
if ($_SESSION['level']==1) {
	header('location:admin/index');
}
else {
	header('location:user/index');
}
?>