<?php
namespace App\Models;

use System\Filter;
use System\Model;

class LoginModel extends Model
    {
        use Filter;
        private $user;
        private $table_name = "users";
        
        public function checkValidLoginUser($email , $password)
        {
            $user = $this->select('*')
                         ->where( 'email = ? AND verified = ? ',$email , 1)->fetch($this->table_name);                

            if($user)
            {
                $this->user = $user;
                return password_verify($password , $user->password);
            }
        }

        public function user()
        {
            return $this->user;
        }

        public function isLogin()
        {
            $logincode = "";
            if($this->cookie->has("logincode"))
            {
                $logincode = $this->cookie->get("logincode");
            }
            if($this->session->has("logincode"))
            {
                $logincode = $this->session->get("logincode");
            }
            $user = $this->select('*')
            ->where( 'logincode = ? ',$logincode)->fetch($this->table_name);  
            if($user)
            {
                $this->user = $user;
                return true;
            }
            else
            {
                return false;
            }

        }

 



    }
