<?php
namespace App\Models;

use System\Filter;
use System\Model;

class LoginModel extends Model
    {
        use Filter;
        protected $user;
        
        public function checkValidLoginUser($email , $password , $tablename)
        {
            $user = $this->select('*')
                         ->where( 'email = ? AND verified = ? ',$email , 1)->fetch($tablename);                

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

        public function isLogin($tablename)
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
            ->where( 'logincode = ? ',$logincode)->fetch($tablename);  
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
