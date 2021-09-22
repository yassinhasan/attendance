<?php
namespace App\Controllers\Admin;

use System\Controller;

class AreagroupsController extends Controller
{

    public function index()
    {

     // title
      $this->html->setTitle("area groups");

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
        "admin/css/areagroups.css",
      ]);  
      $this->html->setJs([
        "admin/js/jquery.min.js",
        "admin/js/jquery.min.js",
        "admin/js/bootstrap.min.js",
        "admin/js/all.min.js",
        "admin/js/fontawesome.min.js",
        "admin/js/main.js",
        "admin/js/areagroups.js"
      ]);

   
      // load all area groups
      $areagroupodel = $this->load->model("Areagroups");
      $data['custom_add'] = ' Areagroup';
      $data['action']     =  toLink("admin/areagroups/submit");
      $data['load_data']  =  toLink("admin/areagroups/realtime");
      $data['edit_data']  =  toLink("admin/areagroups/edit/");
      $data['delete_data']  =  toLink("admin/areagroups/delete/");
      $data['delete_download']  =  toLink("admin/areagroups/download");

      echo  $this->layout->render($this->view->render("admin\areagroups",$data));
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
              
              $areagroupodel = $this->load->model("areagroups");
              if($areagroupodel->insert())
              {
                  $this->json['suc'] =  'Data inserted successfuly ';
                  $this->json['suc_url'] = toLink("admin/areagroups/realtime");
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
          return $this->validator->require("area_id")
                          ->require("area_name")
                          ->valid();
                         
      }

      public function realtime()
      {
        if(! $this->route->isMatchedMethod()){
          $this->url->header("/");
        }
        $areagroupodel = $this->load->model("areagroups");
        $results =  $areagroupodel->getAll();

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
        $data['action']     =  toLink("admin/areagroups/save/$id");
        $data['custom_add'] = ' Area groups';
        $areagroupodel = $this->load->model("areagroups");
        $data['area_group'] = $areagroupodel->getById($id[0]);

        return $this->view->render("admin/forms/areagroupsform",$data);

      }

      public function save($id)
      {

        if(! $this->route->isMatchedMethod()){
          $this->url->header("/");
        }
        $id = $id[0];
       
        // deleted 
        if(! $this->isValid())
        {
           $this->json['error'] = $this->validator->getAllErrors();
        }else 
        { 
            $areagroupodel = $this->load->model("areagroups");
            if($areagroupodel->update($id))
             {
               $this->json['suc'] = 'updated succsuffuly';
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
        $areagroupodel = $this->load->model("areagroups");
        if($areagroupodel->deleteById($id))
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

          $areagroupodel = $this->load->model("areagroups");
          $results  = $areagroupodel->getAll();

          $output = "";

          $output .= "<table class='table' bordered='1'>
                      <thead>
                      <tr> <th> Area Id</th> </tr>
                      <tr> <th> Area Name </th> </tr>
                      </thead>
                      <tbody>
                      ";
          foreach($results as $result)
          {
               $output .= "<tr>
                                <td>
                                $result->area_id
                                </td>
                                <td>
                                $result->area_name
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
