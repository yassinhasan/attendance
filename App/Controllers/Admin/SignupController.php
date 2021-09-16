<?php
namespace App\Controllers\Admin;

use System\Controller;

class SignupController extends Controller
{
    public function index()
    {

        $this->html->setCss([
            "admin/css/all.min.css",
            "admin/css/bootstrap.css.map",
            "admin/css/bootstrap.min.css",
            "admin/css/fontawesome.min.css",
            "admin/css/signup.css",
          ]);  
          $this->html->setJs([
            "admin/js/jquery.min.js",
            "admin/js/jquery.min.js",
            "admin/js/bootstrap.min.js",
            "admin/js/all.min.js",
            "admin/js/fontawesome.min.js",
            "admin/js/signup.js"
          ]);
        $data['action'] = toLink("admin/signup/submit");
        echo  $this->layout->render($this->view->render("admin\signup",$data) , "nav");
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
            if($usermodel->insert())
            {
                $this->json['suc'] =  'We Send Email For Verfiication ';
                if($usermodel->isSentEmail())
                {
                $this->json['redirect'] = toLink("admin/login");                    
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
                        ->email("email")
                        ->exists(["email","users" , "verified" , 0])
                        ->isVerified(["email","users" , "verified" , 0])
                        ->require("password")
                        ->image("image")
                        ->valid();
                       
    }
}