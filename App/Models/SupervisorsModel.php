<?php
namespace App\Models;
use System\Model;

class SupervisorsModel extends Model
{
    protected $table_name = 'supervisors';

    //        //id	supervisors_id	supervisors_name	supervisors_email	supervisors_password	area_id	group_id	date_of_join	supervisors_image	
    public function insert()
    {

        $supervisors_id  = $this->request->post('supervisors_id');
        $supervisors_name  =$this->request->post('supervisors_name');
        $tablename = $this->table_name;
        $sql ="
        INSERT INTO $tablename (supervisors_id, supervisors_name)
        SELECT * FROM (SELECT '$supervisors_id', '$supervisors_name') AS tmp
        WHERE NOT EXISTS (
            SELECT supervisors_id FROM $tablename WHERE supervisors_id = '$supervisors_id'
        ) LIMIT 1;
        ";
        $stmt = $this->query($sql);
        return  $stmt->rowCount() > 0;
        
    }

    public function getAll()
    {
        $offset = $this->pagination->getOffset();
 
        $limit = $this->request->post("limit") != null ? intval($this->request->post("limit")) : 5;
        $search_id= $this->request->post("search_id");
        $search_item= $this->request->post("search_item");

        $results = [];
        $sql    = " select s.* , ag.area_name from supervisors s 
                    LEFT Join areagroups ag ON s.area_id = ag.area_id
        ";
        $sql2    = " select s.* , ag.area_name from supervisors s 
        LEFT Join areagroups ag ON s.area_id = ag.area_id";

        if( $search_id!= null  AND  $search_id != "" )
        {   
            $sql .= " WHERE supervisors_id LIKE '%".$search_id."%'";
            $sql2 .= " WHERE supervisors_id LIKE '%".$search_id."%'";
        }

        if( $search_item!= null  AND  $search_item != "" )
        {   
            $and = ($search_id!= null  AND  $search_id != "") ? " AND " : " where" ;
            $sql .= " $and supervisors_firstname LIKE '%".$search_item."%'";
            $sql2 .= " $and supervisors_firstname LIKE '%".$search_item."%'";
        }
        if( $limit != null  AND  $limit != "" )
        {   
            $sql .= " limit  " . $limit. " OFFSET ".$offset; ;
        }
         $stmt = $this->query($sql);
         $stmt2 = $this->query($sql2);
         
        $results['allwithlimit'] = $stmt->fetchAll();
        $results['allwithoutlimit'] = $stmt2->fetchAll();
        
        return $results;

    }


    public function getById($id)
    {
        $results = $this->select(" * ")->where(" id = ? " , $id)->fetch($this->table_name);
        return $results;
    }
    public function previewById($id)
    {
        $results = $this->select(" s.* , ag.area_name  ,  us.group_name ")->Join(" 
            LEFT JOIN areagroups ag ON  s.area_id = ag.area_id
            LEFT JOIN usersgroups  us  ON us.group_id = s.group_id
        ")->where(" s.id = ? " , $id)->fetch(" supervisors s");
        return $results;
    }
    public function deleteById($id)
    {
        $supervisors = $this->where(" id = ? " , $id)->delete($this->table_name);
        return $supervisors->rowCount() > 0 ;
    }

    public function update($id)
        {
   
        if($_FILES['image']['name'] == "")
        {
            $image = $this->getById($id)->image;
            
        }else
        {
            $image = $this->request->file('image')->move()->fileSavedNameInDb();
        }
        
        if($this->request->post("password") == ""  OR $this->request->post("password") ==null )
        {
            $password  =  $this->getById($id)->password;
            
        }else
        {
           
            $password = password_hash($this->request->post('newpassword') , PASSWORD_DEFAULT) ;
        }
        
        $email    = $this->request->post('email');
        $firstname =$this->filterSTR($this->request->post('firstname'));
        $lastname =$this->filterSTR($this->request->post('lastname'));
        $user = $this->db->data([
            "firstname" =>  $firstname,
            "lastname"  =>  $lastname,
            "email"  =>  $email,
            "image"     =>  $image,
            "group_id"  =>  1,
            "area_id"   =>   $this->request->post("area_id"),
            "logintime" =>  time(),
            "logincode" =>  sha1(rand(0,1000)),
            "status"    =>  'approved',
            "password"  =>   $password ,
            "verified" => 1
        ])->where(" id = ? " , $id)->update($this->table_name);
        return $user->rowCount() > 0; 
        
    }
    public function insertWithOutVervication($tablename)
    {
        // 	firstname	lastname	image	group_id	logintime	logincode	statu password
        
        $groupid = $tablename == "supervisors" ? 1 : 3;
        $columnname = $tablename == "supervisors" ? "supervisors_id" : "users_id";
        $image = $this->request->file('image')->move()->fileSavedNameInDb();
        $email    = $this->request->post('email');
        $firstname =$this->filterSTR($this->request->post('firstname'));
        $user = $this->db->data([
            "firstname" =>  $firstname,
            "lastname"  =>  $this->request->post('lastname'),
            $columnname  =>  $this->request->post($columnname),
            "email"  =>  $email,
            "image"     =>  $image,
            "group_id"  =>  $groupid,
            "area_id"   =>   $this->request->post("area_id"),
            "logintime" =>  time(),
            "logincode" =>  sha1(rand(0,1000)),
            "status"    =>  'approved',
            "password"  =>  password_hash($this->request->post('password') , PASSWORD_DEFAULT) ,
            "verified" => 1
        ])->insert($tablename);
        return $user->rowCount() > 0;

    }
    public function getAllArea()
    {
       $result = $this->select( " * ")->from(" areagroups")->fetchAll() ;
       return $result;
    }
    
    
    
}