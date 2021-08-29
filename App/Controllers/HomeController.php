<?php
namespace App\Controllers;

use System\Controller;

class HomeController extends Controller
{

    public function index()
    {
     echo  $this->app->view->render("home");
    }

    public function submit()
    {

        if($this->app->route->isMatchedMethod())
        {

                    
                    if($this->app->validator->image('image')->valid() )
                    {

                        echo $this->app->validator->fileSavedNameInDb();
                    }else
                    {
                        pre($this->app->validator->getAllErrors());
                    }
                    

        }
        else
        {
            header("location: /");
        }
    }

 
    

}