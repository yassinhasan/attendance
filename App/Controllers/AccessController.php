<?php
namespace App\Controllers;

use System\Controller;

class AccessController extends Controller 
{
    public function index()
    {
        $excpetion_url = [
            "/admin/login" , 
            "/admin/logout" , 
            "/admin/login/submit" , 
            "/admin/signup", 
            "/admin/verify",
            "/admin/verify/submit",
            "/admin/signup/submit" , 
            "/",
            "notfound",
            "notaccess",
            "/users/signup/submit" , 
            "/users/signup", 
            "/users/login" , 
            "/users/logout" , 
            "/users/login/submit" , 
            "/users/verify",
            "/users/verify/submit",
        ];




        $user= $this->load->model("login");
        
        if( (! $user->isLogin("users") AND ! $user->isLogin("supervisors")) AND !in_array($this->request->url() , $excpetion_url) )
        {
         
             $this->url->header("/");
        }
        if($user->isLogin("users") OR  $user->isLogin("supervisors")  )
        {

            $loggeduser = $user->user();
            $usersgroupsmodel = $this->load->model("usersgroups");
            $user_permessions = [];
            $allowedpermessions = $usersgroupsmodel->getAllowedPermessions($loggeduser->group_id);
            foreach($allowedpermessions as $allowedpermession)
            {

                  $user_permessions[] = $allowedpermession->permession_name;
            }
            
            
            if(!in_array($this->route->currentUrl() , $user_permessions ) )
            {
                  $this->url->header("notaccess");
              
            }
        }

    }
}