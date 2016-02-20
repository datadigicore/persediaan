<?php
include('../../utility/mysql_db.php');
class modelUpb extends mysql_db
{
	public function bacaunit($data)
  {
    $query = "select kodesektor, namasatker from satker
            where kodesektor is not null and
                kodesatker is null and
                kodeunit is null and
                gudang is null and 
                tahun is null or
                tahun = '$data' and 
                CHAR_LENGTH(kode) = 2
            order by kodesektor asc";
    $result = $this->query($query);
    echo '<option value="">-- Pilih Kode Unit --</option>';
    while ($row = $this->fetch_array($result))
    {
      if (!empty($row)) {
        echo '<optgroup label="'.$row['kodesektor'].' '.$row['namasatker'].'">';
        $query2 = "select kodesektor, kodesatker, namasatker from satker
            where kodesektor ='$row[kodesektor]' and
                kodesatker is not null and
                kodeunit is null and
                gudang is null 
            order by kodesektor asc";
        $result2 = $this->query($query2);
        while ($row2 = $this->fetch_array($result2))
        {
          if (!empty($row2)) {
            echo '<optgroup label="&nbsp;&nbsp;'.$row2['kodesektor'].'.'.$row2['kodesatker'].' '.$row2['namasatker'].'">';
            $query3 = "select kodesektor, kodesatker, kodeunit, namasatker from satker
                where kodesektor ='$row2[kodesektor]' and
                    kodesatker ='$row2[kodesatker]' and
                    kodeunit is not null and
                    gudang is null 
                order by kodesatker asc";
            $result3 = $this->query($query3);
            while ($row3 = $this->fetch_array($result3))
            {
              if (!empty($row3)) {
                echo '<optgroup label="&nbsp;&nbsp;&nbsp;&nbsp;'.$row3['kodesektor'].'.'.$row3['kodesatker'].'.'.$row3['kodeunit'].' '.$row3['namasatker'].'">';
                $query4 = "select kodesektor, kodesatker, kodeunit, gudang, namasatker from satker
                    where kodesektor ='$row3[kodesektor]' and
                        kodesatker ='$row3[kodesatker]' and
                        kodeunit ='$row3[kodeunit]' and
                        gudang is not null and
                        kd_ruang is null
                    order by gudang asc";
                $result4 = $this->query($query4);
                while ($row4 = $this->fetch_array($result4))
                {
                  echo '<option value="'.$row4['kodesektor'].'.'.$row4['kodesatker'].'.'.$row4['kodeunit'].'.'.$row4['gudang'].'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row4['kodesektor'].'.'.$row4['kodesatker'].'.'.$row4['kodeunit'].'.'.$row4['gudang'].' '.$row4['namasatker']."</option>";
                }
                echo '</optgroup>';
              }              
            }
            echo '</optgroup>';
          }
        }
        echo '</optgroup>';
      }
    }
  } 
	public function tambahsubbag($data)
	{
        $query = "insert into satker
            set kodesektor ='$data[kodesektor]',
            kodesatker     ='$data[kodesatker]',
            kodeunit       ='$data[kodeunit]',
            gudang         ='$data[kodeupb]',
            kd_ruang       ='$data[kdsubbag]',
            namasatker     ='$data[nmsubbag]',
            tahun          ='$data[tahun]',
            kode           ='$data[kodesektor].$data[kodesatker].$data[kodeunit].$data[kodeupb]'";
        $result = $this->query($query);
		return $result;
	} 	
	public function ubahunit($data)
	{
		$query = "update satker
            set kodesektor  ='$data[updkdsektor]',
            kodesatker      ='$data[updkdsatker]',
            kodeunit        ='$data[updkdunit]',
            gudang          ='$data[updkdgudang]',
            kd_ruang        ='$data[updkdsubbag]',
            namasatker      ='$data[updnmsubbag]',
            kode            ='$data[updkdsektor].$data[updkdsatker].$data[updkdunit].$data[updkdgudang]'
            where satker_id ='$data[id]'";
        $result = $this->query($query);
		return $result;
	}	
	public function hapusunit($data)
	{
		$query = "delete from satker where satker_id='$data'";
        $result = $this->query($query);
		return $result;
	}
}
?>