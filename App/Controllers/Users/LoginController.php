<?php
namespace App\Controllers\Users;

use System\Controller;

class LoginController extends Controller
{
    public function index()
    {
        $loginmodel = $this->load->model("login");
        if($loginmodel->isLogin())
        {
            $this->url->header("/");
        }
        $this->html->setTitle("login");
        $this->html->setCss("users/css/login");
        $this->html->setCss("users/css/style");
        $this->html->setJs("users/js/login");
        $this->html->setJs("users/js/main");
        $data['action'] = toLink("users/login/submit");
        echo  $this->layout->render($this->view->render("users\login",$data));
    }

    public function submit()
    {
        $this->isValid();
        return $this->json();


    }

    public function isValid()
    {
        $valid =  (bool) $this->validator
                        ->require("email")
                        ->email("email")
                        ->isVerified(["email","users" , "verified" , 0])
                        ->require("password")
                        ->valid();            
        if($valid == false)
        {
            $this->json['error'] = $this->validator->getAllErrors();
            
        }
        else
        {
            $email = $this->request->post('email');
            $password = $this->request->post('password');
            $loginmodel = $this->load->model("login");
            $user = $loginmodel->checkValidLoginUser($email , $password);
            
            if($user)
            {
                $logeduser = $loginmodel->user();
                if(isset($_POST['remember']) AND $this->request->post('remember') == "on")
                {
                   
                    $this->cookie->setCookie("logincode" , $logeduser->logincode , 1);
                }
                else
                {
                    $this->session->set("logincode" , $logeduser->logincode);
                }
                $this->json['suc'] = $loginmodel->user();
                $this->json['redirect'] = toLink("/");
            }
            else
            {
                $this->json['invalid'] = 'invalid data';   
            }

        }                
                       
    }
}