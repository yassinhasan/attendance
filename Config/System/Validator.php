<?php 
namespace System;
class Validator
{
    private $app;
    private $error = [];
    private $file_saved_name_in_db;
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function getValue($input)
    {
        return $this->app->request->post($input);
    }

    public function message($inputvalue ,$message = null)
    {
      return  $this->error[$inputvalue] = $message;
    }
    public function hasEroor($input)
    {
        return array_key_exists($input , $this->error);
    }

    public function getAllErrors()
    {
        return $this->error;
    }

    public function getErrorMessages()
    {
        return implode("<br>",$this->error);
    }

    public function require($input,$message = null)
    {
        if($this->hasEroor($input))
        {
            return $this;
        }
        $inputvalue = $this->getValue($input);
        if($inputvalue == "" or $inputvalue == null)
        {
            $message = $message !== null ? $message : sprintf("sorry  %s is required",$input);
            $this->message($input,$message);
        }
        return $this;
    }
    public function isInt($input,$message = null)
    {
        if($this->hasEroor($input))
        {
            return $this;
        }
        $inputvalue = $this->getValue($input);
        if(! preg_match("/[0-9]+/",$inputvalue))
        {
            $message = $message !== null ? $message : sprintf("sorry  %s is NOT NUMBER",$input);
            $this->message($input,$message);
        }
        return $this;
    }
    public function oldPassword($table,$message = null)
    {

        // select password from supervisors where password = "hasan" and id = id

        $inputvalue = $this->getValue($table[0]); //hasan
        if($inputvalue != "")
        {
            if(count($table) == 4)
            {
                // // select password from supervisors where password = "hasan" and id = id  $table = ['password' , 'supervisors' , 'id' , 4]
                list($coulmn , $table_name , $id , $idvalue) = $table;
                if($inputvalue !== "" or $inputvalue != null)
                {
                    $result = $this->app->db->select($coulmn)->from($table_name)->where(" $id = ? ",  $idvalue)->fetch();
                    
                    if($result != null)
                    {
                        if(! password_verify($inputvalue,$result->password))
                        {
                            $message = $message !== null ? $message : sprintf("sorry old  %s is not valid",$coulmn);
                            $this->message($coulmn,$message);
                        }
                    }
                }
            }
         }
        return $this;
    }

    public function MatchOldPassword($password , $newoassword , $matchedpassword , $message = null)
    {
        
        if($this->hasEroor($password))
        {
            return $this;
        }else
        {
            $inputvalue = $this->getValue($newoassword);
            $inputvalue2 = $this->getValue($matchedpassword);
            if($inputvalue != "" or $inputvalue != null AND $inputvalue2 != "" or $inputvalue2 != null )
            {

                // if( !$this->isInt($newoassword))
                // {
                //     $message = $message !== null ? $message : sprintf("sorry new password must be numebr only  %s is not valid",$newoassword);
                //     $this->message($newoassword,$message);
                // }
                $this->require($password);
                if( $inputvalue !== $inputvalue2)
                {
                    $message = $message !== null ? $message : sprintf("sorry confirm password not match with new password");
                   $this->message($matchedpassword,$message);
                }
            }
        }
        return $this;
    }

    public function email($input,$message = null)
    {
        if($this->hasEroor($input))
        {
            return $this ;
        }
        $inputvalue = $this->getValue($input);   
        if(! $inputvalue == "")
        {
            if(! filter_var($inputvalue,FILTER_VALIDATE_EMAIL))
            {
                $message = $message !== null ? $message : sprintf("sorry  %s is not valid email",$input);
                $this->message($input,$message);
            } 
        }

        return $this;
    }
    

    public function image($input,$message= null)
    {
         
        $image = $this->app->request->file($input);
        if(!$image->noError())
        {
            foreach($image->getEroors() as $err)
            {
                $message = $message !== null ? $message : $err;
                $this->message($input,$message);
            }

        }
        // else
        // {
        //     $image->move();
        //     $this->file_saved_name_in_db = $image->fileSavedNameInDb();
        // }
        return $this;    
    }

    public function exists(array $table ,$message = null)
    {
        // select email from column where tablename = figo78a@gmail.com and excpetion != exveptionvalue

        $inputvalue = $this->getValue($table[0]);
        if($this->hasEroor($table[0]))
        {
            return $this;
        }


        if(count($table) == 2)
        {    
             list($coulmn , $table_name) = $table;
             if($inputvalue !== "" or $inputvalue != null)
                {
                    $result = $this->app->db->select($coulmn)->from($table_name)->where("$coulmn = ? ", $inputvalue)->fetch();
                }
        }
        elseif(count($table) == 4)
        {
            // select $cloumn from tablename where $cloumn = figo78a@gmail.com and excpetion != exveptionvalue  $table = ['email' , 'users' , 'id' , 4]
            list($coulmn , $table_name , $exception , $exceptionvalue) = $table;
            if($inputvalue !== "" or $inputvalue != null)
            {
                $result = $this->app->db->select($coulmn)->from($table_name)->where("$coulmn = ?  AND $exception != ? ", $inputvalue  , $exceptionvalue)->fetch();
            }
        }


        if($result != null)
        {
            $message = $message !== null ? $message : sprintf("sorry  %s is exists ",$coulmn);
            $this->message($coulmn,$message);
        }

        return $this;
    }
    public function existsInAnother(array $table ,$message = null)
    {
        // (["users_id","supervisors_id" , "supervisors"])  
        $columnname =  $table[0];     
        if($this->hasEroor($table[0])) // it return value of value of variavle
        {
            return $this;
        }
        $inputvalue = $this->getValue(array_shift($table)); // == users_id 

        $coulmn = $table[0] ;
        $table_name = $table[1]; // [supervisors_id" , "supervisors"];
        if($inputvalue !== "" or $inputvalue != null)
        {
            $result = $this->app->db->select($coulmn)->from($table_name)->where(" $coulmn = ? ", $inputvalue)->fetch();
            if($result != null)
            {
                $message = $message !== null ? $message : sprintf("sorry  %s is exists by %s ",$columnname , $table_name);
                $this->message($columnname,$message);
            }
        }


        return $this;
    }

    public function isVerified(array $table ,$message = null)
    {
        // select email from column where tablename = figo78a@gmail.com and excpetion != exveptionvalue

        $inputvalue = $this->getValue($table[0]);
        if($this->hasEroor($table[0]))
        {
            return $this;
        }
        if(count($table) == 4)
        {
            // select $cloumn from tablename where $cloumn = figo78a@gmail.com and excpetion != exveptionvalue  $table = ['email' , 'users' , 'id' , 4]

            list($coulmn , $table_name , $exception , $exceptionvalue) = $table;
            if($inputvalue !== "" or $inputvalue != null)
            {
                $result = $this->app->db->select($coulmn)->from($table_name)->where("$coulmn = ?  AND $exception = ? ", $inputvalue  , $exceptionvalue)->fetch();
            }
        }


        if($result != null)
        {
            $message = $message !== null ? $message : sprintf("sorry  %s is already signed up but need to verify account by email ",$coulmn);
            $this->message($coulmn,$message);
        }

        return $this;
    }

    public function valid()
    {
        return empty($this->error);
    }


    public function fileSavedNameInDb()
    {
            return $this->file_saved_name_in_db;

    }

}