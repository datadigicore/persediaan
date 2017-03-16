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
	$_SESSION['thn_ang']     = $purifier->purify($_POST['thn_ang']);
	$_SESSION['level']       = $data['user_level'];
	$_SESSION['start']       = time();
	$_SESSION['expire']      = $_SESSION['start'] + (120 * 60);
    header('location:../index');
}
else {
    header('location:../login');
} 	
