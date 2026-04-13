<?php
    namespace app\admin\comment;
    use app\core\QController;
    use app\models\Comment;

    class CommentAdminDelete extends QController{
        public $db;
        public $model;
        public function __construct(){
        }
        public function get($pk = null){
            $this->comment = $this->db->query(new Comment)->filter($pk)->first();
            $this->db->delete($this->comment);
            return header("Location: {$this->route->url_for('admin_comment')}");
        }
   }