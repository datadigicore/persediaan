<?php
include('../../utility/mysql_db.php');
class modelDashboard extends mysql_db
{
	public function countdata()
	{
		$sql1="select kodesektor from satker
					where kodesektor is not null and
						kodesatker is null and
						kodeunit is null and
						gudang is null and
						kd_ruang is null";
		$sql2="select kodesatker from satker
					where kodesektor is not null and
						kodesatker is not null and
						kodeunit is null and
						gudang is null and
						kd_ruang is null";
		$sql3="select kodeunit from satker
					where kodesektor is not null and
						kodesatker is not null and
						kodeunit is not null and
						gudang is null and
						kd_ruang is null";
		$sql4="select gudang from satker
					where kodesektor is not null and
						kodesatker is not null and
						kodeunit is not null and
						gudang is not null and
						kd_ruang is null";
		$result1 = $this->query($sql1);
		$result2 = $this->query($sql2);
		$result3 = $this->query($sql3);
		$result4 = $this->query($sql4);
   		$totalsektor = mysqli_num_rows($result1);
   		$totalsatker = mysqli_num_rows($result2);
   		$totalunit = mysqli_num_rows($result3);
   		$totalgudang = mysqli_num_rows($result4);
  		echo json_encode(array("sektor"=>$totalsektor,"satker"=>$totalsatker,"unit"=>$totalunit,"gudang"=>$totalgudang));
	}
}
?>