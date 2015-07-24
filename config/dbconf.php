<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University

date_default_timezone_set("Asia/Jakarta"); 

$sql_details = array(
    'user' => 'root',
    'pass' => '',
    'db'   => 'persediaan_v1',
    'host' => 'localhost'
);

$connect = mysqli_connect($sql_details['host'], $sql_details['user'], $sql_details['pass'], $sql_details['db']) or die(mysql_error()); 

?>
