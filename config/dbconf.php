<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University

date_default_timezone_set("Asia/Jakarta"); 

class config {
    
    public $db_host = "localhost";
    public $db_user = "root";
    public $db_pass = "";
    public $database = "persediaan_v1";

    public function open_connection() {
	    $this->link_db = mysqli_connect($this->db_host, $this->db_user, $this->db_pass,$this->database)or die("Koneksi Database gagal");
	    return $this->link_db;
    }

    public function sql_details() {
    	$this->sql_details = array(
		    'user' => $this->db_user,
		    'pass' => $this->db_pass,
		    'db'   => $this->database,
		    'host' => $this->db_host
		);
		return $this->sql_details;
    }

}

?>
