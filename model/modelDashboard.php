<?php
include('../../utility/mysql_db.php');
class modelDashboard extends mysql_db
{
	public function countdata()
	{
		$sql1="select * from uapb";
		$sql2="select * from uappbe1";
		$sql3="select * from uappbw";
		$sql4="select * from uakpb";
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