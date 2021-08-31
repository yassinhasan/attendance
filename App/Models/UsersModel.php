<?php
namespace App\Models;


use System\Model;

class UsersModel extends Model
    {
        private $table_name = "users";

        /**
         * @ mixed params
         * @return boll
         */
        public function insert()
        {
            // 	firstname	lastname	image	group_id	logintime	logincode	statu password

            $image = $this->request->file('image')->move()->fileSavedNameInDb();


            $user = $this->db->data([
                "firstname" =>  $this->filterSTR($this->request->post('firstname')),
                "lastname"  =>  $this->request->post('lastname'),
                "email"  =>  $this->request->post('email'),
                "image"     =>  $image,
                "group_id"  =>  1,
                "logintime" =>  time(),
                "logincode" =>  sha1(rand(0,1000)),
                "status"    =>  'approved',
                "password"  =>  password_hash($this->request->post('password') , PASSWORD_DEFAULT) 
            ])->insert($this->table_name);

            if($user->rowCount() > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

    }
