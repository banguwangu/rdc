<?php
    namespace app\admin\entry;
    use app\core\QController;
    use app\models\Entry;
    class EntryAdminDelete extends QController{
        public $db;
        public $model;
        public function __construct(){
        }
        public function get($pk = null){
            $this->entry = $this->db->query(new Entry)->filter($pk)->first();
            $this->db->delete($this->entry);
            return header("Location: {$this->route->url_for('admin_entry')}");
        }
   }