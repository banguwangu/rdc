<?php
    namespace app\admin\entry;
    use app\core\QController;
    use app\models\Entry;

    class EntryAdmin extends QController{
        public $db;
        public $model;
        public function __construct(){
        }
        public function queryManager(){
            $entry = $this->db->query(new Entry);
            if(isset($_GET['query'])){
                $entry = $entry->filter(array('title' => $_GET['query']), 'LIKE');
            }
            return $entry->all();
        }
        public function entries(){
            
            return $this->queryManager();
        }
        public function get(){
            return $this->get_template('admin/entries');
        }
   }