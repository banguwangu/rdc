<?php
	
    namespace app\core;

    use app\core\QDatabase;

	abstract class QModel{
        public string $id;
        public function __construct(){

            $this->id = " INT(11) PRIMARY KEY AUTO_INCREMENT ";
        }
        public function createTable(){
            $stmt = "
                CREATE TABLE IF NOT EXISTS `".strtolower($this->__tablename__)."`(
                    ".$this->getColDefinitions()."
                )
            ";
            return $stmt;
        }
        public function getColDefinitions(){
            $attrs = $this->getDefs();
            $cols_stmt = '' ;
            $cols =  [];
            foreach (array_keys($attrs) as $key => $value) {
                $cols[] = "`".$value."` ".$this->{$value};
            }
            $cols_stmt .= implode(',', $cols);         

            return $cols_stmt;
        }
        public function getColumns(){
            return "`".implode('`,`', array_keys($this->getDefs()))."`";
        }
        public function getDefs(){
            $list =  [];
            foreach (get_object_vars($this) as $key => $value) {
                if($key != '__tablename__'){
                    $list[$key] = $value;
                }
            }
            return $list;
        }
        public function getValues(){
            $list =  [];
            foreach (get_object_vars($this) as $key => $value) {
                if($key != '__tablename__'){
                    $list[$key] = $value;
                }
            }
            return $list;
        }
        public function getValuePlaceholders(){
            $list = [];
            foreach($this->getDefs() as $key => $value){
                if($key != "__tablename__"){
                    $list[$key] = " :" . $key;
                }
            }
            return implode(", ", $list);
        }
        public function getColList(){
            return array_keys($this->getDefs());
        }
        public function getUpdatePlaceholders(){
            $cols = array_keys($this->getDefs());
            $cols = array_map(function($col){
                return ($col != "id") ? "`".$col."` = :".$col : ""; 
            }, $cols);
            return ltrim(implode(", ", $cols), ", ");
        }
   }