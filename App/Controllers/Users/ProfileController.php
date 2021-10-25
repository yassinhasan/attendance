<?php
namespace App\Controllers\Users;

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
        "users/css/all.min.css",
        "users/css/bootstrap.css.map",
        "users/css/bootstrap.min.css",
        "users/css/fontawesome.min.css",
        "users/css/profile.css",
      ]);  
      $this->html->setJs([
        "users/js/jquery.min.js",
        "users/js/jquery.min.js",
        "users/js/bootstrap.min.js",
        "users/js/all.min.js",
        "users/js/fontawesome.min.js",
        "users/js/profile.js"
      ]);

   
      // load all profile
      $data['custom_add'] = ' Profile';
      $data['allarea'] = $this->load->model("profile")->getAllArea();
      $user = $this->load->model("login")->user();
      $data['action']     =  toLink("users/profile/updateimage/$user->id");
      $data['update']     =  toLink("users/profile/updateprofile/$user->id");
      $data['user'] = $this->load->model("profile")-> getById("users",$user->id);
      echo  $this->userslayout->render($this->view->render("users\profile",$data));
    }


      public function updateimage($id)
      {
        if(! $this->route->isMatchedMethod()){
          $this->url->header("/");
        }
        $id = $id[0];
        
        if(! $this->isValid())
        {
           $this->json['error'] = $this->validator->getAllErrors();
        }else 
        { 
            $profilemodel = $this->load->model("profile");
            if($profilemodel->updateimage("users",$id))
             {
               
              $image = $profilemodel->getimage("users",$id);
              $image = $image->image;
              $this->json['image'] = $image;
               $this->json['suc'] = 'updated succsuffuly';
             }else
             {
                 $this->json['db_error'] = 'sorry this user is found before';
             }
        }
 
        return $this->json();
      }

      public function isValid($id = null)
      {

        if($id == null)
        {
              return $this->validator
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
          ->exists(["email","users" , "email" , $this->request->post("email")])
          ->valid();
        }
            
      }

      public function updateprofile($id)
      {

        if(! $this->route->isMatchedMethod()){
          $this->url->header("/");
        }
        $id = $id[0];
        if(! $this->isValid($id))
        {
           $this->json['error'] = $this->validator->getAllErrors();
        }else 
        { 
            $profilemodel = $this->load->model("profile");
            if($profilemodel->update("users",$id))
             {
              $profilemodel = $this->load->model("profile");
              $name = $profilemodel->getName("users",$id);
              $firstname = $name->firstname;
              $lastname = $name->lastname;
               $this->json['suc'] = 'updated succsuffuly';
               $this->json['firstname'] = $firstname;
               $this->json['lastname'] = $lastname;
             }else
             {
               $this->json['nochange'] = "no change in info updated";
             }
        }
 
        return $this->json();

      }

      
}
