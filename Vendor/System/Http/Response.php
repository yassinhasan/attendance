<?php
namespace System\Http;
use System\Application;
class Response 
{


        private $output;
        private $headers = [];
        private $app;
        private $content;

        public function __construct(Application $app)
        {
            $this->app = $app;
        }
        
        public function setOutput($content)
        {
            $this->content = $content;
        }
        public function send_output()
        {

           echo $this->content;
        }


        public function setheaders($key,$value)
        {
            return $this->headers[$key] = $value;
        }

        public function sendheaders()
        {
            foreach($this->headers as $key => $value)
            {
                header("$key: $value");
            }
        }

        public function send()
        {
            $this->sendheaders();
            $this->send_output();
        }

}
