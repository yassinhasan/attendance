<?php
namespace App\Controllers\Admin;

use System\Controller;

class PharmaciesController extends Controller
{

    public function index()
    {

     // title
      $this->html->setTitle("Pharmacies");

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
        "admin/css/pharmacies.css",
      ]);  
          
      $this->html->setJs([
        "admin/js/jquery.min.js",
        "admin/js/jquery.min.js",
        "admin/js/bootstrap.min.js",
        "admin/js/all.min.js",
        "admin/js/fontawesome.min.js",
        "admin/js/main.js",
        "admin/js/pharmacies.js"
      ]);


    //  load all area groups
      $pharmaciesmodel = $this->load->model("pharmacies");
      $data['allsupervisors'] = $pharmaciesmodel->getSupervisors();
      $data['allarea'] = $pharmaciesmodel->getAllArea();
      $data['custom_add'] = ' pharmacies';
      $data['action']     =  toLink("admin/pharmacies/submit");
      $data['load_data']  =  toLink("admin/pharmacies/realtime");
      $data['edit_data']  =  toLink("admin/pharmacies/edit/");
      $data['delete_data']  =  toLink("admin/pharmacies/delete/");
      $data['delete_download']  =  toLink("admin/pharmacies/download");


      echo  $this->layout->render($this->view->render("admin\pharmacies",$data));
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
              
              $pharmaciesmodel = $this->load->model("pharmacies");
              if($pharmaciesmodel->insert())
              {
                  $this->json['suc'] =  'Data inserted successfuly ';
                  $this->json['suc_url'] = toLink("admin/pharmacies/realtime");
                                  
  
              }else
              {
                  $this->json['db_error'] = 'sorry this PHARMACY is found before';
              }
          }
          return $this->json();
  
  
      }
  
      public function isValid()
      {
          return $this->validator->require("area_id")
                          ->require("pharmacies_id")
                          ->isInt("pharmacies_id")
                          ->valid();
                         
      }

      public function realtime()
      {
        if(! $this->route->isMatchedMethod()){
          $this->url->header("/");
        }
        $pharmaciesmodel = $this->load->model("pharmacies");
        $results =  $pharmaciesmodel->getAll();

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
        $pharmaciesmodel = $this->load->model("pharmacies");
        $data['allsupervisors'] = $pharmaciesmodel->getSupervisors();
        $data['allarea'] = $pharmaciesmodel->getAllArea();
        $data['selected'] =  $pharmaciesmodel-> getById($id);
        $data['action']     =  toLink("admin/pharmacies/save/$id");
        $data['custom_add'] = ' pharmacies ';
        $pharmaciesmodel = $this->load->model("pharmacies");
        $data['area_group'] = $pharmaciesmodel->getById($id[0]);
        return $this->view->render("admin/forms/pharmaciesform",$data);

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
            $pharmaciesmodel = $this->load->model("pharmacies");
            if($pharmaciesmodel->update($id))
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
        $pharmaciesmodel = $this->load->model("pharmacies");
        if($pharmaciesmodel->deleteById($id))
        {
          $this->json['suc'] = 'data deleted';
        }
      return $this->json();
      }

      public function download()
      {

          $pharmaciesmodel = $this->load->model("pharmacies");
          $results  = $pharmaciesmodel->getAll();

          $output = "";

          $output .= "<table class='table' bordered='1'>
                      <thead>
                      <tr> <th> Area Id</th> </tr>
                      <tr> <th> Pharmacy Name </th> </tr>
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
                                $result->pharmacies_id
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
