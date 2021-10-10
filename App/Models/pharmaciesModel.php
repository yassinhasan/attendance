<?php
namespace App\Models;
use System\Model;

class pharmaciesModel extends Model
{
    protected $table_name = 'pharmacies';

    
    public function insert()
    {

        $area_id  = $this->request->post('area_id');
        $pharmacies_id  =$this->request->post('pharmacies_id');
        $tablename = $this->table_name;
        $sql ="
        INSERT INTO $tablename (area_id, pharmacies_id ) 
        SELECT * FROM (SELECT '$area_id', '$pharmacies_id') AS tmp
        WHERE NOT EXISTS (
            SELECT area_id   FROM $tablename WHERE pharmacies_id = '$pharmacies_id'
        ) LIMIT 1;
        ";
        $stmt = $this->query($sql);
        return  $stmt->rowCount() > 0;
        
    }

    public function getAll()
    {

        //       $result = $this->select( " s.firstname , s.lastname , s.pharmacies_id")->from(" supervisors s")->join( " LEFT JOIN areagroups ag ON  ag.supervisors_id = s.supervisors_id")->fetchAll() ;

        $offset = $this->pagination->getOffset();
 
        $limit = $this->request->post("limit") != null ? intval($this->request->post("limit")) : 5;
        $search_id= $this->request->post("search_id");
        $search_item= $this->request->post("search_item");

        $results = [];
        $sql    = " select p.* , ag.area_name from pharmacies p 
                    Join areagroups ag ON p.area_id = ag.area_id
        ";
        $sql2    = " select p.* , ag.area_name from pharmacies p 
                    Join areagroups ag ON p.area_id = ag.area_id
        ";

        if( $search_id!= null  AND  $search_id != "" )
        {   
            $sql .= " WHERE area_name LIKE '%".$search_id."%'";
            $sql2 .= " WHERE area_name LIKE '%".$search_id."%'";
        }

        if( $search_item!= null  AND  $search_item != "" )
        {   
            $and = ($search_id!= null  AND  $search_id != "") ? " AND " : " where" ;
            $sql .= " $and pharmacies_id LIKE '%".$search_item."%'";
            $sql2 .= " $and pharmacies_id LIKE '%".$search_item."%'";
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
    public function deleteById($id)
    {
        $area = $this->where(" id = ? " , $id)->delete($this->table_name);
        return $area->rowCount() > 0 ;
    }

    public function update($id)
    {
        $area = $this->db->data([
                    "area_id"  =>  $this->request->post('area_id'),
                    "pharmacies_id"  =>  $this->request->post('pharmacies_id'),

            ])->where(" id = ? " , $id)->update($this->table_name);   
        return $area->rowCount() > 0 ;

    }

    public function getSupervisors()
    {
       $result = $this->select( " * ")->from(" supervisors")->fetchAll() ;
       return $result;
    }
    public function getAllArea()
    {
       $result = $this->select( " * ")->from(" areagroups")->fetchAll() ;
       return $result;
    }

    
    
    
}