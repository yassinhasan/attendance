<?php
namespace App\Controllers;

use System\Controller;

class AccessController extends Controller 
{
    public function index()
    {
        $excpetion_url = [
            "/admin/login" , 
            "/admin/login/submit" , 
            "/users/login" , 
            "/users/login/submit" , 
            "/admin/signup" , 
            "/admin/signup/submit" , 
            "/users/signup/submit" , 
            "/",
            "notfound",
            "notaccess",
            "/users/verify",
            "/users/verify/submit",
        ];




        $user= $this->load->model("login");
        if( ! $user->isLogin() AND !in_array($this->request->url() , $excpetion_url) )
        {
               $this->url->header("admin/login");
        }
        if($user->isLogin()  )
        {
         
             /// now iam login  // then get user
            $loggeduser = $user->user();
            $usersgroupsmodel = $this->load->model("usersgroups");
            $user_permessions = [];
            $allowedpermessions = $usersgroupsmodel->getAllowedPermessions($loggeduser->group_id);
            foreach($allowedpermessions as $allowedpermession)
            {

                  $user_permessions[] = $allowedpermession->permession_name;
            }
            

            //   pre($user_permessions); echo $this->route->currentUrl() ; die;
            
       
            if(!in_array($this->route->currentUrl() , $user_permessions ) )
            {
              $this->url->header("notaccess");
            }
        }
            

        // }
        
        
        //else 
        // {
            
        // }
    }
}