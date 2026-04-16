<?php
    namespace app\admin\user;
    use app\core\QController;
    use app\models\Users;
    
    class UserCreate extends QController{
        public $db;
        public $model;
        public function __construct(){
        }
        public function get($pk = null){
           if($pk != null){
                $this->user = $this->db->query(new Users)->filter($pk)->first();
            }
            return $this->get_template('admin/user_create');
        }
        public function post($pk = null){
            if($pk != null){
                $user = $this->getUser($pk);
                $user = new Users($this->route->form);
                $stmt = $this->db->update($user);
            }else{
                $user = new Users($this->route->form);
                $stmt = $this->db->add($user);
            }
            $this->db->commit($stmt);
            return header("Location:{$this->route->url_for('admin_user')}");
        }
        public function getUser($pk){
            return $this->db->query(new Users)->filter($pk)->first();
        }
   }