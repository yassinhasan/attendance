<?php
namespace App\Controllers\Users;

use System\Controller;

class LogoutController extends Controller
{

  
    public function index()
    {  
        if($this->cookie->has("logincode"))
        {
            $this->cookie->remove("logincode");
        }
        if($this->session->has("logincode"))
        {
            $this->session->remove("logincode");
        }
        $this->url->header("/");
    }
}