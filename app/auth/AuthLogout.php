<?php
	namespace app\auth;
    use app\core\QController;

	class AuthLogout extends QController{
		public function __construct(){
			parent::__construct();
		}
		public function get(){
			unset($_SESSION['user']);
			return header("Location:{$this->route->url_for('auth_login')}");
		}
	}