<?php
	namespace app\auth;
	use app\models\Users;
	use app\core\QController;

	class AuthRegister extends QController{
		public $db;
        public $model;
        public $errors =[];
        public function __construct(){

        }
        public function get(){
            return $this->get_template('auth/register');
        }
        public function post(){
            $this->errors = [];
            if($this->route->request['requestMethod']=="POST"){
                foreach($this->route->form as $key => $value){
                    if(empty($value)){
                        $this->errors[$key] ="Field Should not be empty!";
                    }
                }
                if(count($this->errors) == 0){
                    print_r($this->route->form);
                    $user = new Users(
                        $this->route->form
                    );
                    $user= $this->db->add($user);
                    $this->db->commit($user);
                    return header("Location:".$this->route->url_for('auth_login'));
                }
            }
        	return $this->get_template('auth/register');
        }  
   }