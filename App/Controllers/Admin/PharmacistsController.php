<?php
namespace App\Controllers\Admin;

use System\Controller;

class PharmacistsController extends Controller
{

    public function index()
    {

     // title
      $this->html->setTitle("pharmacists");

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
        "admin/css/pharmacists.css",
      ]);  
      $this->html->setJs([
        "admin/js/jquery.min.js",
        "admin/js/jquery.min.js",
        "admin/js/bootstrap.min.js",
        "admin/js/all.min.js",
        "admin/js/fontawesome.min.js",
        "admin/js/main.js",
        "admin/js/pharmacists.js"
      ]);

   
      // load all pharmacists
      $pharmacistsmodel = $this->load->model("pharmacists"); 
      $data['allpharmacies'] = $pharmacistsmodel->getAllPharmacies();
      $data['custom_add'] = ' Pharmacists';
      $data['action']     =  toLink("admin/pharmacists/submit");
      $data['load_data']  =  toLink("admin/pharmacists/realtime");
      $data['edit_data']  =  toLink("admin/pharmacists/edit/");
      $data['delete_data']  =  toLink("admin/pharmacists/delete/");
      $data['show_data']  =  toLink("admin/pharmacists/preview/");
      $data['delete_download']  =  toLink("admin/pharmacists/download");

      echo  $this->layout->render($this->view->render("admin\pharmacists",$data));
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
              
              $pharmacistsmodel = $this->load->model("pharmacists");
              if($pharmacistsmodel->insertWithOutVervication("users"))
              {
                  $this->json['suc'] =  'Data inserted successfuly ';
                  $this->json['suc_url'] = toLink("admin/pharmacists/realtime");
              }else
              {
                  $this->json['db_error'] = 'sorry this user is found before';
              }
          }
          return $this->json();
  
  
      }
  
      public function isValid($id = null)
      {
        //	id	users_id	firstname	lastname	email	image	status	group_id	pharmacy_id	logintime	logincode	password	verified	verified_code	

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
        $pharmacistsmodel = $this->load->model("pharmacists");
        $results =  $pharmacistsmodel->getAll();

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
        $pharmacistsmodel = $this->load->model("pharmacists"); 
        $data['allpharmacies'] = $pharmacistsmodel->getAllPharmacies();
        $data['selected'] =  $pharmacistsmodel-> getById($id);
        $data['action']     =  toLink("admin/pharmacists/save/$id");
        $data['custom_add'] = ' Pharmacists';
        $pharmacistsmodel = $this->load->model("pharmacists");
        $data['pharmacists_group'] = $pharmacistsmodel->getById($id[0]);
        return $this->view->render("admin/forms/pharmacistsform",$data);

      }
      public function preview($id)
      {
        $id = $id[0];
        if(! $this->route->isMatchedMethod()){
          $this->url->header("/");
        }
        $pharmacistsmodel = $this->load->model("pharmacists"); 
        $data['allpharmacies'] = $pharmacistsmodel->getAllPharmacies();
        $data['selected'] =  $pharmacistsmodel-> previewById($id);
        $data['action']     =  toLink("admin/pharmacists/preview/$id");
        $data['pharmacists_group'] = $pharmacistsmodel->getById($id[0]);
        return $this->view->render("admin/forms/pharmacistpreview",$data);

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
            $pharmacistsgroupodel = $this->load->model("pharmacists");
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

      public function delete($id)
      {
        if(! $this->route->isMatchedMethod()){
          $this->url->header("/");
        }
        $id = $id[0];
        $pharmacistsgroupodel = $this->load->model("pharmacists");
        if($pharmacistsgroupodel->deleteById($id))
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

          $pharmacistsmodel = $this->load->model("pharmacists");
          $results =  $pharmacistsmodel->getAll();

          $output = "";

          $output .= "<table class='table' bordered='1'>
                      <thead>
                      <tr> <th> Pharmacists Id</th>
                      <th> Pharmacists Name </th> </tr>
                      </thead>
                      <tbody>
                      ";
                    
          foreach($results['allwithlimit'] as $result)
          {
               $output .= "<tr>
                                <td>
                                $result->users_id
                                </td>
                                <td>
                                $result->firstname
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
