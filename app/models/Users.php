<?php
	namespace app\models;
	use app\core\QModel;

    trait UserMixin{
        public function verify_password($password){
            return password_verify($password, $this->password_hash);
        }
        public function generate_password_hash($password){
            
            return password_hash($password, PASSWORD_DEFAULT);
           
        }
    }
	class Users extends QModel{
        use UserMixin;
        public string $username;
        public string $email;
        public string $is_active;
        public string $password_hash;
        public string $__tablename__ = 'users';
        public function __construct($kwargs=null){
            if(!$kwargs){
                $this->username = "VARCHAR(200) ";
                $this->email = " VARCHAR(60) UNIQUE ";
                $this->password_hash = "VARCHAR(100) UNIQUE";
                $this->is_active = "BOOLEAN DEFAULT FALSE ";
            }else{
                foreach($kwargs as $key => $value){
                    $exclude = ["password"  ,"confirm_password"];
                    if(!in_array($key,$exclude)){
                        $this->{$key} = $value;
                    }else if($key == "password"){
                        $this->password_hash = $this->generate_password_hash($value);
                    }
                }

            }
            parent::__construct();


        }
   }