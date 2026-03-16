<?php
	namespace app\core;

    

	class QController{
        public $route;
        public function __construct(){

        }
        public function get_template($temp_name){
            return  require(BASE_DIR.sp.'rdc'.sp.'app'.sp.'templates'.sp.str_replace(['/','\\'],sp, $temp_name).'.phtml');
        }
        public function get(){
            print_r('This is a home request');
        }
        public function post(){

        }
   }