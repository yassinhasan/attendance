<?php
namespace App\Controllers\Admin;

use System\Controller;

class SupervisorsController extends Controller
{

    public function index()
    {

     // title
      $this->html->setTitle("supervisors");

      // favicon
      // first get image path
      $image_src = toPublicDirectory('uploades/images/groups.png');
      // $type = pathinfo($path, PATHINFO_EXTENSION);
      $type = pathinfo($image_src,PATHINFO_EXTENSION);
      $file = file_get_contents($image_src);
      $icon = "data:image/".$type.";base64, ".base64_encode($file);

      // i need image path
                   // extension
                   // get file data to encode it
                   // make encode to file by
                   // data:image/   then type then ';base64, ' then base_encode(data)
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
        "admin/css/supervisors.css",
      ]);  
      $this->html->setJs([
        "admin/js/jquery.min.js",
        "admin/js/jquery.min.js",
        "admin/js/bootstrap.min.js",
        "admin/js/all.min.js",
        "admin/js/fontawesome.min.js",
        "admin/js/main.js",
        "admin/js/supervisors.js"
      ]);

   
      // load all supervisors
      $supervisorsmodel = $this->load->model("Supervisors"); 
      $data['allarea'] = $supervisorsmodel->getAllArea();
      $data['custom_add'] = ' Supervisors';
      $data['action']     =  toLink("admin/supervisors/submit");
      $data['load_data']  =  toLink("admin/supervisors/realtime");
      $data['edit_data']  =  toLink("admin/supervisors/edit/");
      $data['delete_data']  =  toLink("admin/supervisors/delete/");
      $data['show_data']  =  toLink("admin/supervisors/preview/");
      $data['delete_download']  =  toLink("admin/supervisors/download");

      echo  $this->layout->render($this->view->render("admin\supervisors",$data));
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
              
              $supervisorsmodel = $this->load->model("supervisors");
              if($supervisorsmodel->insertWithOutVervication("supervisors"))
              {
                  $this->json['suc'] =  'Data inserted successfuly ';
                  $this->json['suc_url'] = toLink("admin/supervisors/realtime");
              }else
              {
                  $this->json['db_error'] = 'sorry this user is found before';
              }
          }
          return $this->json();
  
  
      }
  
      public function isValid($id = null)
      {
        //id	supervisors_id	supervisors_name	supervisors_email	supervisors_password	area_id	group_id	date_of_join	supervisors_image	
        if($id == null)
        {
        return $this->validator
                        ->require("supervisors_id")
                        ->exists(["supervisors_id","supervisors"])
                        ->existsInAnother(["supervisors_id","users_id" , "users"]) // 
                        ->isInt("supervisors_id")
                        ->require("firstname")
                        ->require("lastname")
                        ->require("email")
                        ->require("area_id")
                        ->exists(["area_id","supervisors"])
                        ->email("email")
                        ->exists(["email","supervisors" , "verified" , 0])
                        ->isVerified(["email","supervisors" , "verified" , 0])
                        ->require("password")
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
            ->require("area_id")
            ->exists(["area_id","supervisors" , "id" , $id])
            ->exists(["email","supervisors" , "email" , $this->request->post("email")])
            ->isVerified(["email","supervisors" , "verified" , 0])
            ->valid();
        }

                         
      }

      public function realtime()
      {
        if(! $this->route->isMatchedMethod()){
          $this->url->header("/");
        }
        $supervisorsmodel = $this->load->model("supervisors");
        $results =  $supervisorsmodel->getAll();

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
        $supervisorsmodel = $this->load->model("Supervisors"); 
        $data['action']     =  toLink("admin/supervisors/save/$id");
        $data['allarea'] = $supervisorsmodel->getAllArea();
        $data['selected'] =  $supervisorsmodel-> getById($id);
        $data['update_image']     =  toLink("admin/profile/updateimage/$id");
        $data['custom_add'] = ' Supervisors';
        $supervisorsmodel = $this->load->model("supervisors");
        $data['supervisors_group'] = $supervisorsmodel->getById($id[0]);

        return $this->view->render("admin/forms/supervisorsform",$data);

      }
      public function preview($id)
      {
        $id = $id[0];
        if(! $this->route->isMatchedMethod()){
          $this->url->header("/");
        }
        $supervisorsmodel = $this->load->model("Supervisors"); 
        $data['allarea'] = $supervisorsmodel->getAllArea();
        $data['selected'] =  $supervisorsmodel-> previewById($id);
        $data['action']     =  toLink("admin/supervisors/preview/$id");
        $supervisorsmodel = $this->load->model("supervisors");
        $data['supervisors_group'] = $supervisorsmodel->getById($id[0]);
        return $this->view->render("admin/forms/preview",$data);

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
            $supervisorsgroupodel = $this->load->model("supervisors");
            if($supervisorsgroupodel->update($id))
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
        $supervisorsgroupodel = $this->load->model("supervisors");
        if($supervisorsgroupodel->deleteById($id))
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

          $supervisorsgroupodel = $this->load->model("supervisors");
          $results  = $supervisorsgroupodel->getAll();

          $output = "";

          $output .= "<table class='table' bordered='1'>
                      <thead>
                      <tr> <th> Supervisors Id</th> </tr>
                      <tr> <th> Supervisors Name </th> </tr>
                      </thead>
                      <tbody>
                      ";
          foreach($results as $result)
          {
               $output .= "<tr>
                                <td>
                                $result->supervisors_id
                                </td>
                                <td>
                                $result->supervisors_name
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
