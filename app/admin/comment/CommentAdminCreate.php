<?php
    namespace app\admin\comment;
    use app\core\QController;
    use app\models\Comment;
    
    class CommentAdminCreate extends QController{
        public $db;
        public $model;
        public function __construct(){
        }
        public function get($pk = null){
           if($pk != null){
                $this->comment = $this->db->query(new Comment)->filter($pk)->first();
            }
            return $this->get_template('admin/comment_create');
        }
        public function post($pk = null){
            if($pk != null){
                $comment = $this->getComment($pk);
                $comment = new Comment($this->route->form);
                $stmt = $this->db->update($comment);
            }else{
                $comment = new Comment($this->route->form);
                $stmt = $this->db->add($comment);
            }
            $this->db->commit($stmt);
            return header("Location:{$this->route->url_for('admin_comment')}");
        }
        public function getComment($pk){
            return $this->db->query(new Comment)->filter($pk)->first();
        }
   }