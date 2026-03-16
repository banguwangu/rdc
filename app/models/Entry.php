<?php

	namespace app\models;
	use app\models\QModel;

	class Entry extends QModel{
        public string $title;
        public string $content;
        public string $is_published;
        public function __construct(){
            $this->title = "VARCHAR(255 ";
            $this->content = "TEXT ";
            $this->is_published = " BOOLEAN DEFAULT FALSE  ";

            parent::__construct();
        }
   }