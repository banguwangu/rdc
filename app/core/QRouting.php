<?php

	namespace app\core;
	use app\core\QMiddleware;

	class QRouting{

        public $request = array();
        public $urlparttens = [];
        public $form;
        public function __construct(){
            foreach ($_SERVER as $key => $value) {
                
                $word  = strtolower($key);
                $key_value = explode('_', $word);

                if( count($key_value) > 1){
                    $word = strtolower($key_value[0]);
                    $word .= ucfirst($key_value[1]);
                }
                $this->request[$word] = $value;
            }

            if($this->request['requestMethod'] =="POST"){
                $this->form = $_POST;
            }
        }
        public function processRequest(){

            $middleware = new QMiddleware($this);
            
        }
        public function add($route, $view, $endpoint, $methods){
            $this->urlparttens[$endpoint] = array(
                'url' => $route,
                'view_func'=> $view,
                'endpoint'=> $endpoint,
                'methods'=>$methods,
            );
        }
        public function url_for($endpoint){
           $rawPattern = $this->urlparttens[$endpoint]['url'];
            $cleanPath = str_replace(["#^", "$#", "\\"], "", $rawPattern);

            return DOMAIN . ltrim($cleanPath, '/');
        }
        public function redirect($url){
            return header('location:'.$url);
        }
   }