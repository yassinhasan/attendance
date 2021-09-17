<?php
namespace App\Controllers\Admin;

use System\Controller;

class UsersgroupsController extends Controller
{

    public function index()
    {

     // title
      $this->html->setTitle("users groups");

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
        "admin/css/usersgroups.css",
      ]);  
      $this->html->setJs([
        "admin/js/jquery.min.js",
        "admin/js/jquery.min.js",
        "admin/js/bootstrap.min.js",
        "admin/js/all.min.js",
        "admin/js/fontawesome.min.js",
        "admin/js/main.js",
        "admin/js/usersgroups.js"
      ]);

   
      // load all users groups
      $usersgroupodel = $this->load->model("Usersgroups");
      $data['custom_add'] = ' User Permessions';
      $data['action']     =  toLink("admin/usersgroups/submit");
      $data['load_data']  =  toLink("admin/usersgroups/realtime");
      $data['edit_data']  =  toLink("admin/usersgroups/edit/");
      $data['delete_data']  =  toLink("admin/usersgroups/delete/");
      $data['delete_download']  =  toLink("admin/usersgroups/download");

      echo  $this->layout->render($this->view->render("admin\usersgroups",$data));
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
              
              $usersgroupodel = $this->load->model("usersgroups");
              if($usersgroupodel->insert())
              {
                  $this->json['suc'] =  'Data inserted successfuly ';
                  $this->json['suc_url'] = toLink("admin/usersgroups/realtime");
                //  $this->json['redirect'] = toLink("admin/login");                    
  
              }else
              {
                  $this->json['db_error'] = 'soory this is error in db';
              }
          }
          return $this->json();
  
  
      }
  
      public function isValid()
      {
          return $this->validator->require("group_id")
                          ->require("permession_id")
                          ->valid();
                         
      }

      public function realtime()
      {
        if(! $this->route->isMatchedMethod()){
          $this->url->header("/");
        }
        $usersgroupodel = $this->load->model("usersgroups");
      
       

        $pagination = $this->pagination;
        
        $limit =  $pagination->getLimit();
        $offset =  $pagination->getOffset();

        $search = $this->request->post("search");
        $results = $usersgroupodel->getAllForPagination($limit , $offset);
        $count = 0;
        if( !empty($search))
        {
            $count = count($results);
        }else
        {
           $count  =count($usersgroupodel-> getAllPermession());
        }
        
       
       

        
        $pagination->setCount($count);
        $this->json['all-data'] = $usersgroupodel-> getAllPermession();
        $this->json['total-pages'] =$pagination->getPages() ;
        $this->json['results'] = $results;
        return $this->json();
      }

      // public function search()
      // {
      //   if(! $this->route->isMatchedMethod()){
      //     $this->url->header("/");
      //   }
      //   $usersgroupodel = $this->load->model("usersgroups");
      //   $results = $usersgroupodel->getgetBYsearch();
      //   $this->json['results'] = $results;
      //   return $this->json();
      // }


      public function edit($id)
      {
        $id = $id[0];
        if(! $this->route->isMatchedMethod()){
          $this->url->header("/");
        }
        $data['action']     =  toLink("admin/usersgroups/save/$id");
        $data['custom_add'] = ' User Permessions';
        $usersgroupodel = $this->load->model("usersgroups");
        $data['user_permessions'] = $usersgroupodel->getById($id[0]);
        $selected_permessions =[];
        foreach($data['user_permessions'] as $user)
        {
            $selected_permessions [] = $user->permession_id;
        }
        $data['selected_permessions'] = $selected_permessions;;
        return $this->view->render("admin/forms/usergroupsform",$data);

      }

      public function save($id)
      {

        if(! $this->route->isMatchedMethod()){
          $this->url->header("/");
        }
        $id = $id[0];
        $usersgroupodel = $this->load->model("usersgroups");
        // deleted 
         if($usersgroupodel->get_diffrent_selected_perpession($id))
         {
           $this->json['suc'] = 'updated succsuffuly';
         }
        return $this->json();

      }

      public function delete($id)
      {
        if(! $this->route->isMatchedMethod()){
          $this->url->header("/");
        }

        $deleted_permession = $this->request->post("permession_id");
        $id = $id[0];
        $usersgroupodel = $this->load->model("usersgroups");
        if($usersgroupodel->deleteById($id , $deleted_permession))
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

          $usersgroupodel = $this->load->model("usersgroups");
          $results  = $usersgroupodel->getAllPermession();

          $output = "";

          $output .= "<table class='table' bordered='1'>
                      <thead>
                      <tr> <th> user type </th> </tr>
                      <tr> <th> allowed permession </th> </tr>
                      </thead>
                      <tbody>
                      ";
          foreach($results as $result)
          {

              
             
               
        
               $output .= "<tr>
                                <td>
                                $result->group_name
                                </td>
                                <td>
                                $result->permession_name
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
