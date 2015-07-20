<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University

date_default_timezone_set("Asia/Jakarta"); 
$host = 'localhost'; 
$user = 'root'; 
$pass = 'm4st3r4dm1n';
$dbname = 'persediaan_v1';
$connect = mysqli_connect($host, $user, $pass, $dbname) or die(mysql_error()); 
?>
