<?php
include('../../utility/mysql_db.php');
class modelDashboard extends mysql_db
{
	public function countdata()
	{
		$sql1="select kd_uapb from satker
					where kd_uapb is not null and
						kd_uappbe1 is null and
						kd_uappbw is null and
						kd_uakpb is null";
		$sql2="select kd_uappbe1 from satker
					where kd_uapb is not null and
						kd_uappbe1 is not null and
						kd_uappbw is null and
						kd_uakpb is null";
		$sql3="select kd_uappbw from satker
					where kd_uapb is not null and
						kd_uappbe1 is not null and
						kd_uappbw is not null and
						kd_uakpb is null";
		$sql4="select kd_uakpb from satker
					where kd_uapb is not null and
						kd_uappbe1 is not null and
						kd_uappbw is not null and
						kd_uakpb is not null";
		$result1 = $this->query($sql1);
		$result2 = $this->query($sql2);
		$result3 = $this->query($sql3);
		$result4 = $this->query($sql4);
   		$totaluapb = mysqli_num_rows($result1);
   		$totaluappbe = mysqli_num_rows($result2);
   		$totaluappbw = mysqli_num_rows($result3);
   		$totaluakpb = mysqli_num_rows($result4);
  		echo json_encode(array("uapb"=>$totaluapb,"uappbe"=>$totaluappbe,"uappbw"=>$totaluappbw,"uakpb"=>$totaluakpb));
	}
}
?>