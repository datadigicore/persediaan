<?php
include('../../utility/mysql_db.php');
class modelDashboard extends mysql_db
{
	public function check_tahun($data)
	{
		$query = "SELECT a.tahun, b.status FROM user as a, thn_aktif as b where a.tahun = b.tahun AND a.user_name='$data' order by a.tahun asc ";
		$result =  $this->query($query);
		echo '<option selected="selected">-- Pilih Tahun Anggaran --</option>'; 
		while ($row = $this->fetch_array($result))
		{
			if ($row['status'] == "Aktif") {
				echo '<option value="'.$row['tahun'].'">'.$row['tahun'].'&nbsp;&nbsp;&nbsp;'.$row['status']."</option>";
			}
			else{
				echo '<option value="'.$row['tahun'].'">'.$row['tahun']."</option>";
			}
		}

	}
	public function countdata()
	{
		$sql1="select kodesektor from satker
					where kodesektor is not null and
						kodesatker is null and
						kodeunit is null and
						gudang is null";
		$sql2="select kodesatker from satker
					where kodesektor is not null and
						kodesatker is not null and
						kodeunit is null and
						gudang is null";
		$sql3="select kodeunit from satker
					where kodesektor is not null and
						kodesatker is not null and
						kodeunit is not null and
						gudang is null";
		$sql4="select gudang from satker
					where kodesektor is not null and
						kodesatker is not null and
						kodeunit is not null and
						gudang is not null";
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
	public function bacatahun()
	{
		$query = "select tahun, status from thn_aktif
						order by tahun asc";
        $result = $this->query($query);
        echo '<option selected="selected">-- Pilih Tahun Anggaran --</option>';
        while ($row = $this->fetch_array($result))
		{
			if ($row['status'] == "Aktif") {
				echo '<option value="'.$row['tahun'].'">'.$row['tahun'].'&nbsp;&nbsp;&nbsp;'.$row['status']."</option>";
			}
			else{
				echo '<option value="'.$row['tahun'].'">'.$row['tahun']."</option>";
			}
		}	
	}
}
?>