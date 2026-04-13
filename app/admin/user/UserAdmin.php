<?php
    namespace app\admin\user;
    use app\core\QController;
    use app\models\Users;
    
    class UserAdmin extends QController{
        public $db;
        public $model;
        public function __construct(){
        }
        public function queryManager(){
            $user = $this->db->query(new Users);
            if(isset($_GET['query'])){
                $user = $user->filter(array('username' => $_GET['query']), 'LIKE');
            }
            return $user->all();
        }
        public function users(){
            return $this->queryManager()?? null;
        }
        public function get(){
            return $this->get_template('admin/users');
        }
   }