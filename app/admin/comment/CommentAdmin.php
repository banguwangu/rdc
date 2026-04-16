<?php
	namespace app\admin\comment;
	use app\core\QController;
	use app\models\{
        Comment,
        Entry
    };

	class CommentAdmin extends QController{
        public $db;
        public $model;
        public function __construct(){
        }
        public function queryManager(){
            $comment = $this->db->query(new Comment);
            if(isset($_GET['query'])){
                $comment = $comment->filter(['content' => $_GET['query']], 'LIKE');
            }
            return $comment->all();
        }
        public function posts(){
            return $this->db->query(new Entry)->all();
        }
        public function comments(){
            
            return $this->queryManager();
        }
        public function get(){
            return $this->get_template('admin/comments');
        }
   }