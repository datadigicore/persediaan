<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University

if(!isset($_SESSION))
{
    session_start();
}
$now = time();
if ($now > $_SESSION['expire'])
{
  session_destroy();
  header("Location:../login");
}
?>
