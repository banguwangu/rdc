<?php
    namespace app\admin\entry;
    use app\core\QController;
    use app\models\Entry;
    
    class EntryAdminCreate extends QController{
        public $db;
        public $model;
        public function __construct(){
        }
        public function get($pk = null){
           if($pk != null){
                $this->entry = $this->db->query(new Entry)->filter($pk)->first();
            }
            return $this->get_template('admin/entry_create');
        }
        public function post($pk = null){
            if($pk != null){
                $entry = $this->getEntry($pk);
                $entry = new Entry($this->route->form);
                $stmt = $this->db->update($entry);
            }else{
                $entry = new Entry($this->route->form);
                $stmt = $this->db->add($entry);
            }
            $this->db->commit($stmt);
            return header("Location:{$this->route->url_for('admin_entry')}");
        }
        public function getEntry($pk){
            return $this->db->query(new Entry)->filter(...$pk)->first();
        }
   }