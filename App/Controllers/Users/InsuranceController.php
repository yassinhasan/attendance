<?php
namespace App\Controllers\Users;

use System\Controller;

class InsuranceController extends Controller
{

    public function index()
    {

      $this->html->setTitle("Insurance");
      $image_src = toPublicDirectory('uploades/images/1.png');
      $type = pathinfo($image_src,PATHINFO_EXTENSION);
      $file = file_get_contents($image_src);
      $icon = "data:image/".$type.";base64, ".base64_encode($file);
      $this->html->setCdn("favicon","<link rel='icon' type='image/png'  href='$icon'>");   
      // all js files
      $this->html->setCss([
        "users/css/all.min.css",
        "users/css/bootstrap.css.map",
        "users/css/bootstrap.min.css",
        "users/css/fontawesome.min.css",
        "users/css/insurance.css",
      ]);  
      $this->html->setJs([
        "users/js/jquery.min.js",
        "users/js/jquery.min.js",
        "users/js/bootstrap.min.js",
        "users/js/all.min.js",
        "users/js/fontawesome.min.js",
        "users/js/insurance.js"
      ]);

   
      // load all profile
      
      $user = $this->load->model("login")->user();
      $data['user'] = $this->load->model("profile")-> getById("users",$user->id);
      $insurancemodel = $this->load->model("insurance"); 
      $data['allcompanies'] = $this->load->model("insurance")->getAllCompanies(); 
      $data['alldrugs'] = $this->load->model("insurance")->getAllDrugs(); 
      $data['custom_add'] = ' insurance';
      $data['action']     =  toLink("users/insurance/submit");
      $data['load_data']  =  toLink("users/insurance/realtime");
      $data['edit_data']  =  toLink("users/insurance/edit/");
      $data['delete_data']  =  toLink("users/insurance/delete/");
      $data['show_data']  =  toLink("users/insurance/preview/");
      $data['delete_download']  =  toLink("users/insurance/download");
      echo  $this->userslayout->render($this->view->render("users\insurance",$data));
    }


    public function submit()
      {
          if(! $this->route->isMatchedMethod()){
            $this->url->header("/");
          }

          if(! $this->isValid())
          {
             $this->json['error'] = $this->validator->getAllErrors();
          }
          else
          {
              $user = $this->load->model("login")->user();
              $insurancemodel = $this->load->model("insurance");
              if($insurancemodel->insert($user))
              {
                  $this->json['suc'] =  'Data inserted successfuly ';
                  $this->json['suc_url'] = toLink("users/insurance/realtime");
              }else
              {
                  $this->json['db_error'] = 'sorry errore';
              }
          }
          return $this->json();
  
  
      }
  
      public function isValid($id = null)
      {
        // id	name	mobile	company	dispensed_time	next_dispensed_time	user_id	drugs period	notes	files	
        if($id == null)
        {
        return $this->validator
                        ->require("name")
                        ->exists(["name","insurance"])
                        ->require("mobile")
                        ->exists(["mobile","insurance"])
                        ->require("company")
                        ->require("dispensed_time")
                        ->require("next_dispensed_time")
                      //  ->require("drugs")
                        ->require("period")
                        ->multipleImages("files")
                        ->valid();
        }else
        {
            return $this->validator
            ->require("name")
            ->require("mobile")
            ->require("company")
            ->require("dispensed_time")
            ->require("next_dispensed_time")
          //  ->require("drugs")
            ->require("period")
            ->multipleImages("files")
            ->valid();
        }              
      }

      public function realtime()
      {
        if(! $this->route->isMatchedMethod()){
          $this->url->header("/");
        }
        $user = $this->load->model("login")->user();
        $insurancemodel = $this->load->model("insurance");
        $results =  $insurancemodel->getAllWithCondition($user);
        $count =  count($results['allwithoutlimit']);

         $this->json['results'] = $results; 
         $limit = $this->request->post("limit") != null ? intval($this->request->post("limit")) : 5;
         $this->json['total'] = ceil($count / $limit); 
        return $this->json();
      }


      public function edit($id)
      {
        $id = $id[0];
        if(! $this->route->isMatchedMethod()){
          $this->url->header("/");
        }
        $insurancemodel = $this->load->model("insurance"); 
        $data['allcompanies'] = $this->load->model("insurance")->getAllCompanies(); 
        $data['alldrugs'] = $this->load->model("insurance")->getAllDrugs(); 
        $data['action']     =  toLink("users/insurance/save/$id");
        $data['selected'] =  $insurancemodel-> getById($id);
        $data['custom_add'] = ' insurance';
        return $this->view->render("users/forms/insuranceform",$data);

      }
      public function preview($id)
      {
        $id = $id[0];
        if(! $this->route->isMatchedMethod()){
          $this->url->header("/");
        }
        $insurancemodel = $this->load->model("insurance"); 
        $data['selected'] =  $insurancemodel-> previewById($id);
        $data['action']     =  toLink("users/insurance/preview/$id");
        return $this->view->render("users/forms/preview",$data);

      }

      public function save($id)
      {

        if(! $this->route->isMatchedMethod()){
          $this->url->header("/");
        }
        $id = $id[0];
        if(! $this->isValid($id))
        {  
          
          // $name  = $this->request->post('name');
          // if(is_dir(toPublicDirectory("uploades/images/$name")))
          // {
          //   $path = toPublicDirectory("uploades/images/$name");
          //   $files =   array_diff(scandir($path) , ["." , ".."]);
           
          //   foreach($files as $file)
          //   {
          //      if(file_exists($path."/".$file))
          //      {
          //       unlink($path."/".$file);
          //      }
          //   }
          //   //  rmdir(toPublicDirectory("uploades/images/$name"));
          // }
           $this->json['error'] = $this->validator->getAllErrors();
        }else 
        { 
            $insurancemodel = $this->load->model("insurance");
            if($insurancemodel->update($id))
             {
               $this->json['suc'] = 'updated succsuffuly';
             }else
             {
                 $this->json['db_error'] = 'sorry this user is found before';
             }
        }
 
        return $this->json();

      }

      public function delete($id)
      {
        if(! $this->route->isMatchedMethod()){
          $this->url->header("/");
        }
        $id = $id[0];
        $insurancemodel = $this->load->model("insurance");
        if($insurancemodel->deleteById($id))
        {
          $this->json['suc'] = 'data deleted';
        }
      return $this->json();
      }

      public function download()
      {
          // if(! $this->route->isMatchedMethod()){
          //   $this->url->header("/");
          // }

          $insurancemodel = $this->load->model("insurance");
          $user = $this->load->model("login")->user();
          $results  = $insurancemodel->getAllWithCondition($user);
          $output = "";

          $output .= "<table class='table' bordered='1'>
                      <thead>
                      <tr> <th> insurance Id</th> </tr>
                      <tr> <th> insurance Name </th> </tr>
                      </thead>
                      <tbody>
                      ";
          foreach($results as $result)
          {
               $output .= "<tr>
                                <td>
                                $result->insurance_id
                                </td>
                                <td>
                                $result->insurance_name
                               </td>
                        </tr>";
          }

          $output .= "</tbody> </table>";

          header("Content-Type: application/xls");
          header("Content-Disposition: attachment;filename=filename.xls");
          echo $output;
          exit;
    }
    
  
}
