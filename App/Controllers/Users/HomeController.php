<?php
namespace App\Controllers\Users;

use System\Controller;

class HomeController extends Controller
{

    public function index()
    {
        $this->app->html->setTitle("Home Page");
        echo  $this->app->layout->render($this->app->view->render("users\home"));
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