<?php
include('../../utility/mysql_db.php');
class modelKanwil extends mysql_db
{
	public function tambahbrg($data)
	{
		$kd_kbrg = $data['kd_kbrg'];
		$kd_jbrg = $data['kd_jbrg'];
		$nm_brg = $data['nm_brg'];
		$satuan = $data['satuan'];
		$kd_perk = $data['kd_perk'];
		$kd_lokasi = $data['kd_lokasi'];
		$query = "Insert into brg
        			set kd_kbrg='$kd_kbrg',
        			kd_jbrg='$kd_jbrg',
        			nm_brg='$nm_brg',
                    satuan='$satuan',
                    kd_perk='$kd_perk',
                    kd_lokasi='$kd_lokasi'";
        $result = $this->query($query);
		return $result;
	}
}
?>