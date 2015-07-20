<?php
include('../config/dbconf.php');

$select = array();
$sql='select * from uapb';
$result = $connect->query($sql);
echo '<option value="">-- Select Kode UAPB --</option>';
while ($row = mysqli_fetch_array($result))
{
	// $s = array();
	// $s['id'] = $row['kd_uapb'];
	// $s['title'] = $row['nm_uapb'];
	// array_push($select, $s);
	echo '<option value="'.$row['kd_uapb'].'">'.$row['kd_uapb'].' '.$row['nm_uapb']."</option>";
}
// echo json_encode($select);
?>