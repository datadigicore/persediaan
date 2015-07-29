<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University

session_start();

require_once "timeout.php";
if (!isset($_SESSION['username']) || empty($_SESSION['username']) || $_SESSION['level'] != 1)
{
    header('location:../login');
}
?>
