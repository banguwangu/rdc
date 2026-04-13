<?php
    namespace app\admin\user;
    use app\core\QController;
    use app\models\Users;
    
    class UserAdminDelete extends QController{
        public $db;
        public $model;
        public function __construct(){
        }
        public function get($pk = null){
            $this->user = $this->db->query(new Users)->filter($pk)->first();
            $this->db->delete($this->user);
            return header("Location: {$this->route->url_for('admin_user')}");
        }
   }