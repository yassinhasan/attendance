<?php
namespace App\Models;
use System\Model;

class PharmacistsModel extends Model
{
    protected $table_name = 'users';

    //        //id	users_id	users_name	users_email	users_password	area_id	group_id	date_of_join	users_image	
    public function insert()
    {

        $users_id  = $this->request->post('users_id');
        $users_name  =$this->request->post('users_name');
        $tablename = $this->table_name;
        $sql ="
        INSERT INTO $tablename (users_id, users_name)
        SELECT * FROM (SELECT '$users_id', '$users_name') AS tmp
        WHERE NOT EXISTS (
            SELECT users_id FROM $tablename WHERE users_id = '$users_id'
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
        $sql    = " select u.* , p.pharmacies_id , ag.area_name  from users u 
        Join pharmacies p  ON u.pharmacy_id = p.pharmacies_id
        Join areagroups ag  ON ag.area_id = p.area_id WHERE p.pharmacies_id = u.pharmacy_id
        ";
        $sql2    = " select u.* , p.pharmacies_id , ag.area_name  from users u 
        Join pharmacies p  ON u.pharmacy_id = p.pharmacies_id
        Join areagroups ag  ON ag.area_id = p.area_id WHERE p.pharmacies_id = u.pharmacy_id";

        if( $search_id!= null  AND  $search_id != "" )
        {   
            $sql .= " AND u.users_id LIKE '%".$search_id."%'";
            $sql2 .= " AND u.users_id LIKE '%".$search_id."%'";
        }

        if( $search_item!= null  AND  $search_item != "" )
        {   
            // $and = ($search_id!= null  AND  $search_id != "") ? " AND " : " where" ;
            $sql .= "   And  U.firstname LIKE '%".$search_item."%'";
            $sql2 .= " And U.firstname LIKE '%".$search_item."%'";
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
        // " select u.* , p.pharmacies_id , ag.area_name  from users u 
        ///Join pharmacies p  ON u.pharmacy_id = p.pharmacies_id
       // Join areagroups ag  ON ag.area_id = p.area_id WHERE p.pharmacies_id = u.pharmacy_id
        //";
        $results = $this->select("  u.* , p.pharmacies_id , ag.area_name , ug.group_name ")->Join(" 
            LEFT JOIN pharmacies p  ON u.pharmacy_id = p.pharmacies_id
            LEFT JOIN usersgroups ug  ON ug.group_id = u.group_id
            LEFT JOIN areagroups ag  ON ag.area_id = p.area_id
        ")->where(" u.id = ? " , $id)->fetch(" users u");
        return $results;
    }
    public function deleteById($id)
    {
        $users = $this->where(" id = ? " , $id)->delete($this->table_name);
        return $users->rowCount() > 0 ;
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
            "group_id"  =>  3,
            "pharmacy_id"   =>   $this->request->post("pharmacy_id"),
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
        // 		id	users_id	firstname	lastname	email	image	status	group_id	pharmacy_id	logintime	logincode	password	verified	verified_code	

        
        $groupid = $tablename == "users" ? 3 : 1;
        $columnname = $tablename == "users" ? "users_id" : "supervisors_id";
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
            "pharmacy_id"   =>   $this->request->post("pharmacy_id"),
            "logintime" =>  time(),
            "logincode" =>  sha1(rand(0,1000)),
            "status"    =>  'approved',
            "password"  =>  password_hash($this->request->post('password') , PASSWORD_DEFAULT) ,
            "verified" => 1
        ])->insert($tablename);
        return $user->rowCount() > 0;

    }

    public function getAllPharmacies()
    {
       $result = $this->select( " * ")->from(" pharmacies")->fetchAll() ;
       return $result;
    }
    
    
}