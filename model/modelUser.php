<?php
include('../../utility/mysql_db.php');
class modelUser extends mysql_db
{
	public function tambahuser($data)
	{
		$user_id = $data['user_id'];
		$user_name = $data['user_name'];
		$user_pass = $data['user_pass'];
		$user_email = $data['user_email'];
		$user_level = $data['user_level'];
		$query = "Insert into user
        			set user_id='$user_id',
        			user_name='$user_name',
        			user_pass='$user_pass',
                    user_level='$user_level'";         
        $result = $this->query($query);
		return $result;
	}

    public function ubahuser($data)
    {
        $user_id = $data['user_id'];
        $user_name = $data['user_name'];
        $user_pass = $data['user_pass'];
        $user_email = $data['user_email'];
        $user_level = $data['user_level'];
        $query = "update user
                    set user_id='$user_id',
                    user_name='$user_name',
                    user_pass='$user_pass',
                    user_level='$user_level'";
        $result = $this->query($query);
        return $result;
    }   
    
    public function hapususer($data)
    {
        $user_id = $data['user_id'];
        $user_name = $data['user_name'];
        $user_pass = $data['user_pass'];
        $user_email = $data['user_email'];
        $user_level = $data['user_level'];
        $query = "delete from user
                    where user_id='$user_id'";
        $result = $this->query($query);
        return $result;
    }

    public function bacaUser()
    {
        $query = "select * from user";
        $result = $this->query($query);
        echo '<option value="">-- Pilih User Id --</option>';
        while ($row = $this->fetch_array($result))
        {
            echo '<option value="'.$row['user_id'].'">'.$row['user_name'].' '.$row['user_pass'].' '.$row['user_level']"</option>";
        }   
    }
    public function bacatable($data)
    {
        $query = "select * from user
                    where user_id = '$data'";
        $result = $this->query($query);
        while ($row = $this->fetch_assoc($result))
        {
            $rows[] = [$row['user_id'],$row["user_name"],$row["user_pass"],$row["user_level"]];
        }
        echo json_encode($rows);
    }
}
?>