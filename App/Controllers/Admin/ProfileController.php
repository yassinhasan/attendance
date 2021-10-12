<?php
namespace App\Controllers\Admin;

use System\Controller;

class ProfileController extends Controller
{

    public function index()
    {

      $this->html->setTitle("Profile");


      $image_src = toPublicDirectory('uploades/images/groups.png');
      $type = pathinfo($image_src,PATHINFO_EXTENSION);
      $file = file_get_contents($image_src);
      $icon = "data:image/".$type.";base64, ".base64_encode($file);

      $this->html->setCdn("favicon","<link rel='icon' 
      type='image/png' 
      href='$icon'>");
      // all js files
      $this->html->setCss([
        "admin/css/all.min.css",
        "admin/css/bootstrap.css.map",
        "admin/css/bootstrap.min.css",
        "admin/css/fontawesome.min.css",
        "admin/css/main.css",
        "admin/css/profile.css",
      ]);  
      $this->html->setJs([
        "admin/js/jquery.min.js",
        "admin/js/jquery.min.js",
        "admin/js/bootstrap.min.js",
        "admin/js/all.min.js",
        "admin/js/fontawesome.min.js",
        "admin/js/main.js",
        "admin/js/profile.js"
      ]);

   
      // load all profile
      $data['custom_add'] = ' Profile';
      $user = $this->load->model("login")->user();
      $data['user'] = $this->load->model("profile")-> getById($user->id);
      echo  $this->layout->render($this->view->render("admin\profile",$data));
    }

  
      public function isValid($id = null)
      {
        if($id == null)
        {
        return $this->validator
                        ->require("users_id")
                        ->exists(["users_id","users"])
                        ->existsInAnother(["users_id","supervisors_id" , "supervisors"]) // 
                        ->isInt("users_id")
                        ->require("firstname")
                        ->require("lastname")
                        ->require("email")
                        ->require("pharmacy_id")
                        ->email("email")
                        ->exists(["email","users" , "verified" , 0])
                        ->existsInAnother(["email","email" , "supervisors"]) 
                        ->isVerified(["email","users" , "verified" , 0])
                        ->require("password")
                        ->image("image")
                        ->valid();
        }else
        {
            return $this->validator
            ->require("firstname")
            ->require("lastname")
            ->oldPassword(["password" , "users" , "id" , $id])
            ->MatchOldPassword("password" , "newpassword", "confirmpassword")
            ->require("email")
            ->email("email")
            ->require("pharmacy_id")
            ->exists(["email","users" , "email" , $this->request->post("email")])
            ->isVerified(["email","users" , "verified" , 0])
            ->valid();
        }

                         
      }

      public function realtime()
      {
        if(! $this->route->isMatchedMethod()){
          $this->url->header("/");
        }
        $profilemodel = $this->load->model("profile");
        $results =  $profilemodel->getAll();

        $count =  count($results['allwithoutlimit']);

         $this->json['results'] = $results; 
         $limit = $this->request->post("limit") != null ? intval($this->request->post("limit")) : 5;
         $this->json['total'] = ceil($count / $limit); 
        return $this->json();
      }



      public function save($id)
      {

        if(! $this->route->isMatchedMethod()){
          $this->url->header("/");
        }
        $id = $id[0];
       
        // deleted 
        if(! $this->isValid($id))
        {
           $this->json['error'] = $this->validator->getAllErrors();
        }else 
        { 
            $pharmacistsgroupodel = $this->load->model("profile");
            if($pharmacistsgroupodel->update($id))
             {
               $this->json['suc'] = 'updated succsuffuly';
             }else
             {
                 $this->json['db_error'] = 'sorry this user is found before';
             }
        }
 
        return $this->json();

      }
}
