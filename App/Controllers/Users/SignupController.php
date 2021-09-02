<?php
namespace App\Controllers\Users;

use System\Controller;

class SignupController extends Controller
{
    public function index()
    {
        $this->html->setTitle("Signup");
        $this->html->setCss("users/css/signup");
        $this->html->setJs("users/js/signup");
        $data['action'] = toLink("users/signup/submit");
        echo  $this->layout->render($this->view->render("users\signup",$data));
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
                        ->email("email")
                        ->exists(["email","users" , "verified" , 0])
                        ->isVerified(["email","users" , "verified" , 0])
                        ->require("password")
                        ->image("image")
                        ->valid();
                       
    }
}