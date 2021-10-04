<?php
namespace App\Controllers\Admin;

use System\Controller;

class AreasupervisorsController extends Controller
{

    public function index()
    {

     // title
      $this->html->setTitle("Areasupervisors");

      // favicon
      // first get image path
      $image_src = toPublicDirectory('uploades/images/groups.png');
      // $type = pathinfo($path, PATHINFO_EXTENSION);
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
        "admin/css/areasupervisors.css",
      ]);  
      $this->html->setJs([
        "admin/js/jquery.min.js",
        "admin/js/jquery.min.js",
        "admin/js/bootstrap.min.js",
        "admin/js/all.min.js",
        "admin/js/fontawesome.min.js",
        "admin/js/main.js",
        "admin/js/areasupervisors.js"
      ]);

   
      // load all area groups
      $areasupervisorsmodel = $this->load->model("areasupervisors");
      $data['allsupervisors'] = $areasupervisorsmodel->getSupervisors();
      $data['allarea'] = $areasupervisorsmodel->getAllArea();
      $data['custom_add'] = ' areasupervisors';
      $data['action']     =  toLink("admin/areasupervisors/submit");
      $data['load_data']  =  toLink("admin/areasupervisors/realtime");
      $data['edit_data']  =  toLink("admin/areasupervisors/edit/");
      $data['delete_data']  =  toLink("admin/areasupervisors/delete/");
      $data['delete_download']  =  toLink("admin/areasupervisors/download");

      echo  $this->layout->render($this->view->render("admin\areasupervisors",$data));
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
              
              $areasupervisorsmodel = $this->load->model("areasupervisors");
              if($areasupervisorsmodel->insert())
              {
                  $this->json['suc'] =  'Data inserted successfuly ';
                  $this->json['suc_url'] = toLink("admin/areasupervisors/realtime");
                                  
  
              }else
              {
                  $this->json['db_error'] = 'sorry this area id or supervisor id is found before';
              }
          }
          return $this->json();
  
  
      }
  
      public function isValid()
      {
          return $this->validator->require("area_id")
                          ->require("supervisors_id")
                          ->isInt("supervisors_id")
                          ->valid();
                         
      }

      public function realtime()
      {
        if(! $this->route->isMatchedMethod()){
          $this->url->header("/");
        }
        $areasupervisorsmodel = $this->load->model("areasupervisors");
        $results =  $areasupervisorsmodel->getAll();

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
        $areasupervisorsmodel = $this->load->model("areasupervisors");
        $data['allsupervisors'] = $areasupervisorsmodel->getSupervisors();
        $data['allarea'] = $areasupervisorsmodel->getAllArea();
        $data['selected'] =  $areasupervisorsmodel-> getById($id);
        $data['action']     =  toLink("admin/areasupervisors/save/$id");
        $data['custom_add'] = ' areasupervisors ';
        $areasupervisorsmodel = $this->load->model("areasupervisors");
        $data['area_group'] = $areasupervisorsmodel->getById($id[0]);
        return $this->view->render("admin/forms/areasupervisorsform",$data);

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
            $areasupervisorsmodel = $this->load->model("areasupervisors");
            if($areasupervisorsmodel->update($id))
             {
               $this->json['suc'] = 'updated succsuffuly';
             }else
             {
                 $this->json['db_error'] = 'No Updates Happened';
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
        $areasupervisorsmodel = $this->load->model("areasupervisors");
        if($areasupervisorsmodel->deleteById($id))
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

          $areasupervisorsmodel = $this->load->model("areasupervisors");
          $results  = $areasupervisorsmodel->getAll();

          $output = "";

          $output .= "<table class='table' bordered='1'>
                      <thead>
                      <tr> <th> Area Id</th> </tr>
                      <tr> <th> Supervisor Name </th> </tr>
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
                                $result->supervisors_id
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
