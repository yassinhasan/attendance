<?php
namespace App\Models;


use System\Model;

class UsersModel extends Model
    {
        
        protected $emailsent = false;

       
        /**
         * @ mixed params
         * @return boll
         */
        public function insert($tablename)
        {
            // 	firstname	lastname	image	group_id	logintime	logincode	statu password
            
            $groupid = $tablename == "supervisors" ? 1 : 3;
            $columnname = $tablename == "supervisors" ? "supervisors_id" : "users_id";
            $image = $this->request->file('image')->move()->fileSavedNameInDb();
            $verifiedcode  =   substr(uniqid(sha1(rand(0,1000))),0,50);
            $email    = $this->request->post('email');
            $firstname =$this->filterSTR($this->request->post('firstname'));
            $user = $this->db->data([
                "firstname" =>  $firstname,
                "lastname"  =>  $this->request->post('lastname'),
                $columnname  =>  $this->request->post($columnname),
                "email"  =>  $email,
                "image"     =>  $image,
                "group_id"  =>  $groupid,
                "logintime" =>  time(),
                "logincode" =>  sha1(rand(0,1000)),
                "status"    =>  'approved',
                "password"  =>  password_hash($this->request->post('password') , PASSWORD_DEFAULT) ,
                "verified_code" => $verifiedcode
            ])->insert($tablename);
               
            
            if($tablename == "users")
            {
            $url = toLink("users/verify?email=$email&code=$verifiedcode");                
            }else
            {
                $url = toLink("admin/verify?email=$email&code=$verifiedcode");  
            }

            if($user->rowCount() > 0)
            {

                if( sendEMail([
                    "to"             => $email , 
                    "toname"         => $firstname,
                    "subject"        => " verifivation code From Attendacne Website",
                    "body"           => " <h1> WELLCOME  $firstname </h1> <br>
                                        PLEASE CLICK IN THIS <a href='$url'> link </a> TO VERIIVCARION <br>
                                        "
                ]))
                {
                    $this->emailsent = true;
                }
            return true;    
            }
            else
            {
                return false;
            }
        }
        public function isSentEmail()
        {
            return $this->emailsent;
        }

        public function verify($tablename)
        {
            $email = $this->request->get("email");
            $code = $this->request->get("code");
            $user = $this->select( "email , verified_code")->where(" email = ? AND  verified_code = ? AND verified = ? " , $email , $code ,0)->fetch($tablename);
            if($user)
            {
                $this->data([
                    " verified "    => 1 ,
                    " verified_code" => ""
                ])->where( " email = ? AND  verified_code = ? AND verified =? " , $email , $code , 0)->update($tablename);
                return true;
            }else
            {
                return false;
            }
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
                "logintime" =>  time(),
                "logincode" =>  sha1(rand(0,1000)),
                "status"    =>  'approved',
                "password"  =>  password_hash($this->request->post('password') , PASSWORD_DEFAULT) ,
                "verified" => 1
            ])->insert($tablename);
            return $user->rowCount() > 0;

        }


    }
