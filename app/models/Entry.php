<?php

	namespace app\models;
	use app\core\QModel;

	class Entry extends QModel{
        public string $title;
        public string $content;
        public string $is_published;
        public string $date_created;
        public string $__tablename__ = 'entries';
        public function __construct($kwargs = []){
            $this->title = "VARCHAR(255 ";
            $this->content = "TEXT ";
            $this->is_published = " BOOLEAN DEFAULT FALSE  ";
            $this->date_created = "DATETIME DEFAULT CURRENT_TIMESTAMP";
            parent::__construct();

            foreach($kwargs as $key => $value){
                $this->{$key} = $value;
            }
        }
   }