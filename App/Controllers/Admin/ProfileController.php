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
      $data['allarea'] = $this->load->model("profile")->getAllArea();
      $user = $this->load->model("login")->user();
      $data['action']     =  toLink("admin/profile/updateimage/$user->id");
      $data['update']     =  toLink("admin/profile/updateprofile/$user->id");
      $data['user'] = $this->load->model("profile")-> getById($user->id);
      echo  $this->layout->render($this->view->render("admin\profile",$data));
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
            if($profilemodel->updateimage($id))
             {
               
              $image = $profilemodel->getimage($id);
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
          ->oldPassword(["password" , "supervisors" , "id" , $id])
          ->MatchOldPassword("password" , "newpassword", "confirmpassword")
          ->require("email")
          ->email("email")
          ->exists(["email","supervisors" , "email" , $this->request->post("email")])
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
            if($profilemodel->update($id))
             {
              $profilemodel = $this->load->model("profile");
              $name = $profilemodel->getName($id);
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
