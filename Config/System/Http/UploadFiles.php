<?php
namespace System\Http;
class UploadFiles 
{
    private $file =[];
    private $file_name = [];
    private $file_size = [];
    private $file_type = [];
    private $file_error = [];
    private $file_extension = [];
    private $file_temp_name = [];
    private $error = [];
    private $file_saved_name_in_db = [];
    private $allowed_Extension = [
        "gif","jpeg","png"
    ];
    public function __construct($file)
    {
        
        $this->file = $_FILES[$file];
        $this->getImageInfo($this->file);
    }


    
    public function getImageInfo()
    {
      
      if(! $this->isUploaded()){
            $this->error[] = "sorry no file uploaded";
            
        }else
        {
            $this->file_name = $this->file['name'];
            $this->file_size = $this->file['size'];
            $this->file_error = $this->file['error'];
            $this->file_temp_name = $this->file['tmp_name'];
            
            foreach( $this->file['type']  as $type)
            {
                $this->file_extension[] = explode("/",$type)[1];
                $this->file_type[] = explode("/",$type)[0];


            }
                
            // if not image
            if( $this->isImage())
            {
                if($this->isAllowedExtension())
                {
                    $this->isAllowedSize();
                }
            }



        }
    }
    public function isUploaded()
    {
       if(isset($this->file))
       {

       return $this->file['error'][0] === 0 ? true : false;           
       } 

    }
    public function isImage()
    {
        $error = 0;
        for($i = 0 ; $i < count($this->file_type) ; $i ++)
        {
              if($this->file_type[$i] != "image" )
              {
                  $error ++;
                $this->error[] = "soory this".$this->file_name[$i]." is not allowed Image";
              }
        }
      
        return $error == 0;
    }
    public function getEroors()
    {
        return $this->error;
    }

    public function isAllowedExtension()
    {
        $error = 0;
        for($i = 0 ; $i < count($this->file_extension) ; $i ++)
        {
              if(! in_array($this->file_extension[$i] , $this->allowed_Extension) )
              {
                  $error ++;
                $this->error[] = "soory this ".$this->file_name[$i]." is not allowed extension";
              }
        }
      
        return $error == 0;
    }
    public function isAllowedSize()
    {
        $error = 0;
        for($i = 0 ; $i < count($this->file_size) ; $i ++)
        {
              if($this->file_size[$i] >  500000 )
              {
                  $error ++;
                $this->error[] = "soory this".$this->file_name[$i]." is Big in Size";
              }
        }
      
        return $error == 0;
    }
    public function noError()
    {
        return empty($this->error);
    }

    public function move($foldername)
    {
        if($this->noError())
        {
            
           // pre($this->file_temp_name);die;
            for($i = 0 ; $i < count($this->file_temp_name) ; $i ++)
            {
                $extra = \time().sha1(rand(0,1000));
                
                $extra = substr($extra,-5,5);
                $filename = date("Ymd-").$extra.".".$this->file_extension[$i];
            
                $destionaion = toPublicDirectory("uploades/images/$foldername");  
                if(! is_dir($destionaion))
                {
                    mkdir($destionaion,0777,true);
                }        
                if(move_uploaded_file($this->file_temp_name[$i],$destionaion."/".$filename))
                {
                    $this->file_saved_name_in_db[] = $filename;
                } 
            }

        }
        return $this;

    }
    public function fileSavedNameInDb()
    {
        if($this->noError())
        {
            return implode("/",$this->file_saved_name_in_db);
        }

    }
}