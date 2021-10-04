<?php
namespace App\Models;
use System\Model;

class UsersgroupsModel extends Model
{
    protected $table_name = 'usersgroups';

    
    public function insert()
    {
        // 	group_id	permession_id	
        

        $usertype = "";
        $userid = $this->request->post('group_id');
        switch ($userid) {
            case 1:
                $usertype = "admin";
                break;
            case 2:
                $usertype = "supervisors";
                break;
            case 3:
                $usertype = "users";
                break;
        }
        $all_permessions = $this->app->route->allRoutesUrl();
        $this->where( "group_id =  ? " ,$this->request->post('group_id') )->delete($this->table_name);
        $selected_permessions =  $this->request->post('permession_id');
        $user = 0;
        foreach($selected_permessions as $permession)
        {
            $user +=$this->db->data([
                "group_id"  =>  $this->request->post('group_id'),
                "permession_id"  =>  $permession,
                "permession_name" => $all_permessions[$permession],
                " group_name"    => $usertype
    
            ])->insert($this->table_name)->rowCount();
        }

         return $user > 0 ;

    }

    public function getAllPermession()
    {
        $search = $this->request->post("search");
           $results = $this->select(" * ")->fetchAll($this->table_name);
            return $results;
    }



    public function getAll()
    {  

        $offset = $this->pagination->getOffset();
 
        $limit = $this->request->post("limit") != null ? intval($this->request->post("limit")) : 5;
        $search_id= $this->request->post("search_id");
        $search_item= $this->request->post("search_item");

        $results = [];
        $sql = " select * from ".$this->table_name;
        $sql2 = " select * from ".$this->table_name;

        if( $search_id!= null  AND  $search_id != "" )
        {   
            $sql .= " WHERE group_name LIKE '%".$search_id."%'";
            $sql2 .= " WHERE group_name LIKE '%".$search_id."%'";
        }

        if( $search_item!= null  AND  $search_item != "" )
        {   
            $and = ($search_id!= null  AND  $search_id != "") ? " AND " : " where" ;
            $sql .= " $and permession_name LIKE '%".$search_item."%'";
            $sql2 .= " $and permession_name LIKE '%".$search_item."%'";
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
        return $results;
    }
    public function getById($id)
    {
        $results = $this->select(" * ")->where(" group_id = ? " , $id)->fetchAll($this->table_name);
        return $results;
    }

    public function get_diffrent_selected_perpession($id)
    {

        $all_permessions = $this->app->route->allRoutesUrl();
        $this->where( "group_id =  ? " , $id )->delete($this->table_name);
        

         $selected_permessions = $this->request->post("permession_id");

         $updatedpermession = 0 ;
         $usertype = "";
         $userid = $this->request->post('group_id');
         switch ($userid) {
             case 1:
                 $usertype = "admin";
                 break;
             case 2:
                 $usertype = "supervisors";
                 break;
             case 3:
                 $usertype = "users";
                 break;
         }
        foreach ($selected_permessions as $value) {
             $updatedpermession +=  $this->data([
               "permession_id" => $value , 
               "group_id"      => $id,
               "permession_name" => $all_permessions[$value] ,
               " group_name"    => $usertype
           ])->insert($this->table_name)->rowCount();
        }
        
        return $updatedpermession > 0 ;
      
    }


    public function deleteById($id , $deleted_permession)
    { 
        if($this->where(" group_id = ?  AND permession_id = ? " , $id , $deleted_permession)->delete($this->table_name)->rowCount() > 0 ) 
        {
            return true ;
        }else{
            return false;
        }
    }

    public function getgetBYsearch()
    {
      
    }

    public function getAllowedPermessions($id)
    {

        $results = $this->select(" permession_name ")->where(" group_id = ? " , $id)->fetchAll($this->table_name);
        return $results;

    }



        
       
    
}