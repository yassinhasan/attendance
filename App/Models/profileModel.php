<?php
namespace App\Models;
use System\Model;

class profileModel extends Model
{
    protected $table_name = 'supervisors';


    public function getById($id)
    {
        $results = $this->select(" s.* , ag.area_name  ,  us.group_name ")->Join(" 
            LEFT JOIN areagroups ag ON  s.area_id = ag.area_id
            LEFT JOIN usersgroups  us  ON us.group_id = s.group_id
        ")->where(" s.id = ? " , $id)->fetch("$this->table_name s");
        return $results;
    }
    public function update($id)
    {
        $area = $this->db->data([
                    "area_id"  =>  $this->request->post('area_id'),
                    "pharmacies_id"  =>  $this->request->post('pharmacies_id'),

            ])->where(" id = ? " , $id)->update($this->table_name);   
        return $area->rowCount() > 0 ;

    }
}