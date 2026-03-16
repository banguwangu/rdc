<?php
	namespace app\auth;
	use app\core\QDatabase;
	use app\models\Users;
	use app\core\QController;

	class AuthLogin extends QController{
		public $db;
        public $model;
        public $errors = [];
        public function __construct(){

        }
        public function get(){
            return $this->get_template('auth/login');
        }
        public function post(){
            if($this->route->request['requestMethod'] == "POST"){
                $username = $this->route->form['username'];
                $password = $this->route->form['password'];
                $users = $this->db->query(new Users)->filter(...array('username' => $username))->first();

                if ($users != null){
                    if($users->verify_password($password)){
                        echo "You have successfully Signed In ";
                        return $this->route->redirect($this->route->url_for('admin'));
                    }else{
                        $this->errors["password"] = "Password is incorrect ";
                        
                    }
                }else{
                    $this->errors["username"] =  "Invalid Credentials ";
                }
                return $this->get_template('auth/login');
            }
        }
   }