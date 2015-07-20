<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University

if(!isset($_SESSION))
{
	session_start();
}
if (!isset($_SESSION['username']) || empty($_SESSION['username']))
{
    header('location:login');
}