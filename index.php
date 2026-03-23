<?php
    require('config.php');
    
    use app\core\{
        QApplication,
        QRouting,
        QDatabase,
        QModel,
        QController
    };
    use app\models\Users;
    use app\models\Entry;

    use app\auth\AuthLogin;
    use app\auth\AuthRegister;

   class Events extends QModel{

   }
    class AuthMiddleware{

    }
    class Admin extends QController{
        public $db;
        public function __construct(){

            $model = new Users();

        }
        public function get(){
            return $this->get_template('admin/index');
        }
        public function usersCount(){
            $user = $this->db->query(new Users);
            return $user->count();
        }
    }   
   class UserAdmin extends QController{
        public $db;
        public $model;
        public function __construct(){
        }
        public function users(){
            $user = $this->db->query(new Users);
            return $user->all();
        }
        public function get(){
            return $this->get_template('admin/users');
        }
   }
   class UserCreate extends QController{
        public $db;
        public $model;
        public function __construct(){
        }
        public function post($pk = null){
            if($pk){
                $user = $this->getUser($pk);
                $user = new Users($this->route->form);
                $stmt = $this->db->update($user);
            }else{
                $user = new Users($this->route->form);
                $stmt = $this->db->add($user);
            }
            $this->db->commit($stmt);
            return header("Location: /admin/users");
        }
        public function get($pk = null){
            $this->user = $this->getUser($pk);
            return $this->get_template('admin/users');
        }
        public function getUser($pk){
            return  $this->user = $this->db->query(new Users)->filter(...$pk)->first();
        }
   }
   class EntryAdmin extends QController{
        public $db;
        public $model;
        public function __construct(){
        }
        public function entries(){
            $entry = $this->db->query(new Entry);
            return $entry->all();
        }
        public function get(){
            return $this->get_template('admin/entries');
        }
   }
   class Home extends QController{
        public function __construct(){
            $model = new Events();
            $model->query()->fetchAll();
        }
        public function get(){
            return  $this->get_template('index');
        }
   }
   class Contact extends QController{
        public function __construct(){
            $model = new Events();
            $model->query()->fetchAll();
        }
        public function get(){
            return  $this->get_template('index');
        }
   }
   class Blog extends QController{
        public $model;
        public $db;

        public function __construct(){
            /*$this->model = new  QBlog();*/
        }
        public  function object_list(){

        }

        public function get(){
            return $this->get_template('blog');
        }
   }

   $app = new QApplication();
   $app->route->add('#^\/$#', new Home, "index", array(
               'GET', 'POST',
            ));
    $app->route->add('#^/contact$#', new Contact, "contact", array(
                'GET', 'POST'
            ));

    $app->route->add('#^/admin$#', new Admin, "admin", array(
                'GET', 'POST'
            ));
    $app->route->add('#^/admin/users$#', new UserAdmin, "admin_user", array(
                'GET', 'POST'
            ));
    $app->route->add('#^/admin/entries$#', new EntryAdmin, "admin_entry", array(
                'GET', 'POST'
            ));
    $app->route->add('#^/auth/login$#', new AuthLogin, "auth_login", array(
                'GET', 'POST'
            ));

    $app->route->add('#^/auth/register$#', new AuthRegister, "auth_register", array(
                'GET', 'POST'
            ));

    $app->route->add('#^/blog$#', new Blog, "blog", array(
                'GET', 'POST'
            ));
    $app->route->add('#^/blog/{slug}/{id}$#', new Blog, "blog_detail", array(
                'GET', 'POST'
            ));

   $app->run();