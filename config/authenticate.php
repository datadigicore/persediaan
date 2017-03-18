<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University

session_start();

include('dbconf.php');
$config  = new config();
$connect = $config->open_connection();

require_once('../plugins/security/HTMLPurifier.auto.php');
$config_security = HTMLPurifier_Config::createDefault();
$config_security->set('URI.HostBlacklist', array('google.com'));
$purifier = new HTMLPurifier($config_security);

$username = $purifier->purify($_POST['username']);
$password = $purifier->purify(md5($_POST['password']));
$thn_ang  = $purifier->purify($_POST['thn_ang']);
$username = mysql_escape_string($username);
$password = mysql_escape_string($password);
if ($username == "masteradmin" or $username == "adminsimsedia") {
	$sql = "select * from user where user_name='$username' and user_pass='$password'";
}
else{
	$sql = "select * from user where user_name='$username' and user_pass='$password' and tahun='$thn_ang'";
}
$query = mysqli_query($connect,$sql);
$data  = mysqli_fetch_assoc($query);





if (mysqli_num_rows($query) == 1 AND $username == $data['user_name']) {

	$_SESSION['kd_lok']      = $data['kd_lokasi'];
	$_SESSION['kd_ruang']    = $data['kd_ruang'];
	$_SESSION['username']    = $data['user_name'];
	$_SESSION['nama_satker'] = $data['nm_satker'];
	$_SESSION['nm_ruang'] 	 = $data['nm_ruang'];
	$_SESSION['transfer']    = $data['transfer'];
	$_SESSION['akses_menu']    = $data['akses_menu'];
	$_SESSION['thn_ang']     = $purifier->purify($_POST['thn_ang']);
	$_SESSION['level']       = $data['user_level'];
	$_SESSION['start']       = time();
	$_SESSION['expire']      = $_SESSION['start'] + (120 * 60);
	$sql = "SELECT p.id parent_id, a.id menu_id, p.nama_parent, p.nama_ref, a.nama_file, a.nama_menu FROM akses_menu a, parent_menu p where a.parent_id=p.id and p.user_level=$_SESSION[level] and a.id IN ($_SESSION[akses_menu]) LIMIT 0, 30 ";
	$res_menu = mysqli_query($connect, $sql);
	foreach ($res_menu as $key => $value) {
		$_SESSION['menu'][$value['parent_id']] ['nama_parent'] =  $value['nama_parent'];
		$_SESSION['menu'][$value['parent_id']] ['nama_ref'] =  $value['nama_ref'];
		$_SESSION['menu'][$value['parent_id']]['list_menu'][$value['menu_id']]['nama_menu'] =  $value['nama_menu'];
		$_SESSION['menu'][$value['parent_id']]['list_menu'][$value['menu_id']]['nama_file'] =  $value['nama_file'];

	}
	// print_r($_SESSION);
    header('location:../index');
}
else {
    header('location:../login');
} 	
