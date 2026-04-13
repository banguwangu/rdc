<?php

	namespace app\models;
	use app\core\QModel;

	class Comment extends QModel{
        
        public string $content = "TEXT ";
        public string $is_published = " BOOLEAN DEFAULT FALSE  ";
        public string $date_created = "DATETIME DEFAULT CURRENT_TIMESTAMP";
        public string $user_id = " INT(11)";
        public string $post_id = "  INT(11)";
        public string $__tablename__ = 'comments';

        public function __construct($kwargs = []){

            if(isset($kwargs)){
                foreach($kwargs as $key => $value){
                    $this->{$key} = $value;
                }
            }            
        }
        public function foreign_keys(){
            return "
                FOREIGN KEY(`user_id`) REFERENCES `users`(`id`),
                FOREIGN KEY(`post_id`) REFERENCES `entries`(`id`) 
            ";
        }
        public function __get($name){
            if($name == "user"){
                $user = $this->db->query(new Users)->filter(["id"=>$this->user_id])->first();
                return $user ?? null;
            }
            if($name == "post"){
                $post = $this->db->query(new Posts)->filter(["id"=>$this->post_id])->first();
                return $post ?? null;
            }
        }
   }