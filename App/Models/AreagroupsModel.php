<?php
namespace App\Models;
use System\Model;

class AreagroupsModel extends Model
{
    protected $table_name = 'areagroups';

    
    public function insert()
    {
        $area = $this->db->data([
                    "area_id"  =>  $this->request->post('area_id'),
                    "area_name"  =>  $this->request->post('area_name')

            ])->insert($this->table_name);   
        return $area->rowCount() > 0 ;
        
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
            $sql .= " WHERE area_id LIKE '%".$search_id."%'";
            $sql2 .= " WHERE area_id LIKE '%".$search_id."%'";
        }

        if( $search_item!= null  AND  $search_item != "" )
        {   
            $and = ($search_id!= null  AND  $search_id != "") ? " AND " : " where" ;
            $sql .= " $and area_name LIKE '%".$search_item."%'";
            $sql2 .= " $and area_name LIKE '%".$search_item."%'";
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
        $results = $this->select(" * ")->where(" area_id = ? " , $id)->fetch($this->table_name);
        return $results;
    }
    public function deleteById($id)
    {
        $area = $this->where(" area_id = ? " , $id)->delete($this->table_name);
        return $area->rowCount() > 0 ;
    }

    public function update($id)
    {
            $area = $this->db->data([
                    "area_id"  =>  $this->request->post('area_id'),
                    "area_name"  =>  $this->request->post('area_name')

            ])->where(" area_id = ? " , $id)->update($this->table_name);   
        return $area->rowCount() > 0 ;
        
    }

    
    
    
}