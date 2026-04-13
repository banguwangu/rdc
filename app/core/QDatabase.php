<?php

	namespace app\core;
	use PDO;
    use PDOException;

	class QDatabase{
        public $session;
        public $query;
        private $SQLstmt;
        private $model;
        private $abstractor;
        private $SQLargs;
        public function __construct($dbName){

            $dsn = "mysql:host=127.0.0.1;dbname=$dbName;port=3306;charset=utf8mb4";

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $this->abstractor = new PDO($dsn, 'root', '', $options);

            $this->session = $this->abstractor;;

        }
        public function add($model){
            $sqlStmt = "INSERT INTO `".$model->__tablename__."`(".$model->getColumns().") VALUES (".$model->getValuePlaceholders().")";
            print_r($sqlStmt);
            $stmt = $this->session->prepare($sqlStmt);
            foreach($model->getValues() as $key => $value){
                $stmt->bindValue(':'.$key, $value);
            }    
            return $stmt;
        }
        public function update($model){
            $sqlStmt = "UPDATE `".$model->__tablename__."` SET ".$model->getUpdatePlaceholders()." WHERE `id` = :id";
            $stmt = $this->session->prepare($sqlStmt);
            $values = $model->getValues();
            $values['id'] = $model->id;
            foreach($values  as $key => $value){
                $stmt->bindValue(':'.$key, $value);
            }    
            return $stmt;
        }
        public function delete($model){
            $sqlStmt = "DELETE FROM `".$model->__tablename__."` WHERE `id` = :id";
            $stmt = $this->session->prepare($sqlStmt);
            $stmt->bindValue(':id', $model->id);
            return $this->commit($stmt);
        }
        public function commit($stmt){
            return $stmt->execute();
        }
        public function query($model){
            $sqlStmt = "SELECT * FROM `".$model->__tablename__."`";
            $this->SQLstmt = $sqlStmt;
            $this->model = $model;
            return $this;
        }
        public function all(){
            try{
                $table = $this->model->__tablename__;
                $table_exists = $this->session->query("SELECT 1 FROM {$table} WHERE 1");
                
                if($table_exists){
                    echo "Table {$table} does not exist";
                    return null;
                }
            }catch(PDOException){
                $stmt = $this->model->createTable();
                $stmt = $this->session->prepare($stmt);
                $this->commit($stmt);
                return null;
            }
            
            if ($this->SQLargs == null){
                $stmt =  $this->session->query($this->SQLstmt);
            }else{
                $stmt = $this->session->prepare($this->SQLstmt);
                foreach($this->SQLargs as $key => $value){
                    $stmt->bindValue(':'.$key, $value);
                }
                $stmt->execute();

            }
            $this->SQLstmt = null;
            $this->SQLargs = null;
            try{
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($result) == 0){
                    return null;
                }
                $results = [];
                foreach($result as $i => $obj){
                    $model = get_class($this->model);
                    
                    $model  = new $model($obj);
                    $model->db = $this;
                    $results[$i] = $model;

                }
                return $results;
            }catch(\Exception $e){
                return null;
            }
            
        }
        public function first(){
            
            if ($this->SQLargs == null){
                $stmt =  $this->session->query($this->SQLstmt);
            }else{
                $stmt = $this->session->prepare($this->SQLstmt);
                foreach($this->SQLargs as $key => $value){
                    if(isset($_GET['query'])){
                        $value = "%{$value}%";
                    }
                    $stmt->bindValue(':'.$key, $value);
                }
                $stmt->execute();

            }
            
            $this->SQLstmt = null;
            $this->SQLargs = null;
            
            try{
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($result) == 0){
                    return null;
                }else{
                    $model = get_class($this->model);
                    return new $model($result[0]);
                }
            }catch(\Exception $e){
                return null;
            }
            
        }
        public function filter($args, $operator = "=", $logOperator = "AND"){
            $this->SQLargs = $args;
            $this->SQLstmt .= " WHERE ";
            $filter_list = [];
            foreach($args as $key => $value){
                $filter_list[] = "`".$key."` {$operator} :".$key;
            }
            $this->SQLstmt .= implode(" {$logOperator} ", $filter_list);
            return $this;
        }
        public function count(){
            $sql = "SELECT COUNT(*) as Count from ($this->SQLstmt) AS SUBQUERY";
            if ($this->SQLargs == null){
                $stmt =  $this->session->query($sql);
            }else{
                $stmt = $this->session->prepare($sql);
                foreach($this->SQLargs as $key => $value){
                    $stmt->bindValue(':'.$key, $value);
                }
                $stmt->execute();

            }
            $this->SQLstmt = null;
            $model = $this->model;
            try{
                $result = $stmt->fetchAll(PDO::FETCH_OBJ);

                return $result[0]->Count;
            }catch(\Exception $e){
                return null;
            }
            
        }

        
    }