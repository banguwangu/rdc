<?php
    namespace app\core;

	use app\core\QRouting;
    use app\core\QDatabase;

	class QApplication{

        public $route;

        public function __construct(){
            $this->route = new QRouting();
        }
        public function run(){

            $this->route->processRequest();
        }
   }