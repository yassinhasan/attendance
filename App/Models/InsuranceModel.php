<?php
namespace App\Models;
use System\Model;

class InsuranceModel extends Model
{
    protected $table_name = 'insurance';


        //id	name	mobile	company	dispensed_time	period	next_dispensed_time	user_id	drugs	notes	files	
    public function insert($user)
    {

        $name  = $this->request->post('name');
        $mobile  =$this->request->post('mobile');
        $company  =$this->request->post('company');
        $dispensed_time  =$this->request->post('dispensed_time');
        $period  =$this->request->post('period');
        $next_dispensed_time  =$this->request->post('next_dispensed_time');
        $notes  =$this->request->post('notes');
        $files = $this->request->files("files")->move($name)->fileSavedNameInDb(); 
        $insert = $this->db->data([
            "name" =>  $name,
            "mobile"  =>  $mobile,
            "company"  =>  $company,
            "dispensed_time"     =>  $dispensed_time,
            "period"  =>  $period,
            "next_dispensed_time" =>  $next_dispensed_time,
            "user_id" =>  $user->id,
            "notes"    =>  $notes,
            "pharmacy" => $user->pharmacy_id,
            "files"  =>   $files ,
        ])->insert($this->table_name);
        return $insert->rowCount() > 0; 
        
    }

    public function getAllWithCondition($user)
    {
        //         // id	name	mobile	company	dispensed_time	next_dispensed_time	user_id	drugs	notes	files	

        $offset = $this->pagination->getOffset();
 
        $limit = $this->request->post("limit") != null ? intval($this->request->post("limit")) : 5;
        $search_id= $this->request->post("search_id");
        $search_item= $this->request->post("search_item");

        $results = [];
        $sql    = " SELECT * , DATEDIFF (next_dispensed_time , dispensed_time ) as 'remain' FROM $this->table_name WHERE pharmacy = $user->pharmacy_id ";
        $sql2    = "SELECT * , DATEDIFF (next_dispensed_time , dispensed_time) as remain FROM $this->table_name WHERE pharmacy = $user->pharmacy_id ";

        if( $search_id!= null  AND  $search_id != "" )
        {   
            $sql .= " AND name LIKE '%".$search_id."%'";
            $sql2 .= " AND name LIKE '%".$search_id."%'";
        }

        if( $search_item!= null  AND  $search_item != "" )
        {   
            $sql .= " AND mobile LIKE '%".$search_id."%'";
            $sql2 .= " AND mobile LIKE '%".$search_id."%'";
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
        $results = $this->select(" * ")->where(" id = ? " , $id)->fetch($this->table_name);
        return $results;
    }
    public function deleteById($id)
    {

        $insurancename = $this->getById($id)->name;
        if(is_dir(toPublicDirectory("uploades/images/$insurancename")))
        {
                $path = toPublicDirectory("uploades/images/$insurancename");
                $files =   array_diff(scandir($path) , ["." , ".."]);
            
                foreach($files as $file)
                {
                    if(file_exists($path."/".$file))
                    {
                        unlink($path."/".$file);
                    }
                }
             rmdir(toPublicDirectory("uploades/images/$insurancename"));
        }
        $insurance = $this->where(" id = ? " , $id)->delete($this->table_name);
        return $insurance->rowCount() > 0 ;
    }

    public function update($id)
        {
   
            $name  = $this->request->post('name');
            // if(is_dir(toPublicDirectory("uploades/images/$name")))
            // {
            //         $path = toPublicDirectory("uploades/images/$name");
            //         $files =   array_diff(scandir($path) , ["." , ".."]);
                
            //         foreach($files as $file)
            //         {
            //         if(file_exists($path."/".$file))
            //         {
            //             unlink($path."/".$file);
            //         }
            //         }
            //     //  rmdir(toPublicDirectory("uploades/images/$name"));
            // }
            $mobile  =$this->request->post('mobile');
            $company  =$this->request->post('company');
            $dispensed_time  =$this->request->post('dispensed_time');
            $period  =$this->request->post('period');
            $next_dispensed_time  =$this->request->post('next_dispensed_time');
            $notes  =$this->request->post('notes');
            $date = (string)date("Y-m-d");    
                
            $files = $this->request->files("files")->move($name)->fileSavedNameInDb();
            $update = $this->db->data([
                "name" =>  $name,
                "mobile"  =>  $mobile,
                "company"  =>  $company,
                "dispensed_time"     =>  $dispensed_time,
                "period"  =>  $period,
                "next_dispensed_time" =>  $next_dispensed_time,
                "notes"    =>  $notes,
                "files"  =>   $files ,
        ])->where(" id = ? " , $id)->update($this->table_name);
        return $update->rowCount() > 0; 
        
    }

    public function getAllCompanies()
    {
       $result = $this->select( " * ")->from(" insurance_company")->fetchAll() ;
       return $result;
    }
    public function getAllDrugs()
    {
       $result = $this->select( " * ")->from(" drugs ")->fetchAll() ;
       return $result;
    }
    
    
    
    
}