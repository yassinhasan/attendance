<?php
namespace App\Controllers\Users;

use System\Controller;

class VerifyController extends Controller
{
    public function index()
    {
        $this->html->setTitle("verify");
        $this->html->setCss("users/css/verify");
        $this->html->setJs("users/js/verify");
        $data['action'] = toLink("users/verify/submit");
        echo  $this->layout->render($this->view->render("users\\verify",$data));
        /////////////
    }

    public function isValid()
    {
        $email = $this->request->get("email");
        $code = $this->request->get("code");   
        return (! empty($email) AND  !empty($code)); 

    }

    public function submit()
    {
        $usermode = $this->load->model("users");
        $email = $this->request->get("email");;
        $this->json['email']  = $email;
        if($this->isValid())
        {
            
            if($usermode->verify())
            {
                $this->json['suc'] = ' Account Verfied Successfully ';
            }else
            {
                $this->json['exp'] = 'Sorry This link is EXpired';
            }
           $this->json['redirect'] = toLink("users/login"); 
            return $this->json();
            
        }
        return $this->json();
    }
}