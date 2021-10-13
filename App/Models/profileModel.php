<?php
namespace App\Models;
use System\Model;

class profileModel extends Model
{
    protected $table_name = 'supervisors';


    public function getById($id)
    {
        $results = $this->select(" * ")
        ->where(" id = ? " , $id)->fetch("$this->table_name");
        return $results;
    }
    public function getimage($id)
    {
        $results = $this->select(" image ")->where(" id = ? " , $id)->fetch("$this->table_name");
        return $results;
    }
    public function getName($id)
    {
        $results = $this->select(" firstname , lastname , email ")->where(" id = ? " , $id)->fetch("$this->table_name");
        return $results;
    }
    public function updateimage($id)
    {

        $image = $this->request->file('image')->move()->fileSavedNameInDb();
        $user = $this->db->data([
            "image"     =>  $image,
        ])->where(" id = ? " , $id)->update($this->table_name);
        return $user->rowCount() > 0; 

    }
    public function getAllArea()
    {
       $result = $this->select( " * ")->from(" areagroups")->fetchAll() ;
       return $result;
    }

    public function update($id)
    {
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
            "password"  =>   $password ,
        ])->where(" id = ? " , $id)->update($this->table_name);
        return $user->rowCount() > 0; 
        
    }
}