<?php
namespace App\Controllers\Admin;

use System\Controller;

class LoginController extends Controller
{
    public function index()
    {
        $loginmodel = $this->load->model("login");
        if($loginmodel->isLogin())
        {
            $this->url->header("admin");
        }
        $this->html->setTitle("login");
        $this->html->setCss("admin/css/login");
        $this->html->setCss("admin/css/style");
        $this->html->setJs("admin/js/login");
        $this->html->setJs("admin/js/main");
        $data['action'] = toLink("admin/login/submit");
        echo  $this->layout->render($this->view->render("admin\login",$data));
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
                $this->json['redirect'] = toLink("admin");
            }
            else
            {
                $this->json['error'] = 'invalid data';   
            }

        }                
                       
    }
}