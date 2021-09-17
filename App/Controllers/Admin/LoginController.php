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
              // all css 


      $imagesrc = toPublicDirectory("uploades/images/user.png");
      $imagetype = pathinfo($imagesrc,PATHINFO_EXTENSION);
      $file = file_get_contents($imagesrc);

      $icon = "data:image/$imagetype;base64,".base64_encode($file);
      $this->html->setCdn("favicon","<link rel='icon' 
      type='image/png' 
      href='$icon'>");
      $this->html->setCss([
        "admin/css/all.min.css",
        "admin/css/bootstrap.css.map",
        "admin/css/bootstrap.min.css",
        "admin/css/fontawesome.min.css",
        "admin/css/login.css",
      ]);  
      $this->html->setJs([
        "admin/js/jquery.min.js",
        "admin/js/jquery.min.js",
        "admin/js/bootstrap.min.js",
        "admin/js/all.min.js",
        "admin/js/fontawesome.min.js",
        "admin/js/login.js"
      ]);
      
        $data['action'] = toLink("admin/login/submit");
        echo  $this->layout->render($this->view->render("admin\login",$data) , "nav");
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
                $this->json['redirect'] = toLink("admin");
            }
            else
            {
                $this->json['invalid'] = 'invalid data';   
            }

        }                
                       
    }
}