<?php

/*

    pre(key)  function 
    pred(key)  pre + die
    filterstring($key)  
    array_get_value($key,$value,$default = null)


    $app->file->toFile($file)  == __dir__ + file;
    $app->file->toVendor($file)  == __dir__.vendor +  $FILE;
    $app->file->toPublic($file)  == __dir__.public +  $FILE;


    $app->url->link()   == $app->request->baseurl().$path  ==http:://www.attendance.com/$path
    $app->url->header   ==  header("location".$app->request->link($path)) ==   header location      to                   http:://www.attendance.com/$path


    $app->request->baseurl()   to bsae http:://www.attendance.com
    $app->request->prepareurl()  == get request url without "?"  
    $app->request->url()  == get request url

*/
if(! function_exists("pre"))
{
    function pre($key)
    {
        echo "<pre>";
        print_r($key);
        echo "</pre>";
    }
}
if(! function_exists("pred"))
{
    function pred($key)
    {
        echo "<pre>";
        print_r($key);
        echo "</pre>";
        die;
    }
}
if(! function_exists("filterstring"))
{
     function  filterstring($key)
    {
        return filter_var($key,FILTER_SANITIZE_STRING);
    }
}
if(! function_exists("array_get_value"))
{
    function array_get_value($array,$key,$default = null)
    {
        if(array_key_exists($key,$array))
        {
            return $array[$key];
        }
        else
        {
            echo $default;
        }
    }
}