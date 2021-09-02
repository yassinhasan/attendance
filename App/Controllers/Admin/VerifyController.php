<?php
namespace App\Controllers\Admin;

use System\Controller;

class VerifyController extends Controller
{
    public function index()
    {
        $this->html->setTitle("verify");
        $this->html->setCss("admin/css/verify");
        $this->html->setJs("admin/js/verify");
        $data['action'] = toLink("admin/verify/submit");
        echo  $this->layout->render($this->view->render("admin\\verify",$data));
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
           $this->json['redirect'] = toLink("admin/login"); 
            return $this->json();
            
        }
        return $this->json();
    }
}