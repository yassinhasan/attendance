<?php
namespace App\Controllers\Users;

use System\Controller;

class SignupController extends Controller
{
    public function index()
    {
        $loginmodel = $this->load->model("login");
        if($loginmodel->isLogin("users") OR $loginmodel->isLogin("supervisors") )
        {
            
           $this->url->header("usershome") ;
        }
        $this->html->setTitle("Signup");
        $this->html->setCss([
            "users/css/all.min.css",
            "users/css/bootstrap.css.map",
            "users/css/bootstrap.min.css",
            "users/css/fontawesome.min.css",
            "users/css/signup.css",
          ]);  
          $this->html->setJs([
            "users/js/jquery.min.js",
            "users/js/jquery.min.js",
            "users/js/bootstrap.min.js",
            "users/js/all.min.js",
            "users/js/fontawesome.min.js",
            "users/js/signup.js"
          ]);
        $data['action'] = toLink("users/signup/submit");
        echo  $this->userslayout->render($this->view->render("users\signup",$data));
    }

    public function submit()
    {

        if(! $this->isValid())
        {
           $this->json['error'] = $this->validator->getAllErrors();
        }
        else
        {
            
            $usermodel = $this->load->model("users");
            if($usermodel->insert("users"))
            {
                $this->json['suc'] =  'We Send Email For Verfiication ';
                if($usermodel->isSentEmail())
                {
                  $this->json['redirect'] = toLink("users/login");                    
                }

            
            }else
            {
                $this->json['db_error'] = 'soory this is error in db';
            }
        }
        return $this->json();


    }

    public function isValid()
    {
        
        return $this->validator->require("firstname")
                        ->require("lastname")
                        ->require("email")
                        ->require("users_id")
                        ->exists(["users_id","users"])
                        ->existsInAnother(["users_id","supervisors_id" , "supervisors"]) // 
                        ->email("email")
                        ->exists(["email","users" , "verified" , 0])
                        ->isVerified(["email","users" , "verified" , 0])
                        ->require("password")
                        ->image("image")
                        ->valid();
                       
    }
}