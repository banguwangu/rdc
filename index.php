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
    use app\models\Comment;

    use app\auth\{
        AuthLogin,
        AuthRegister, 
        AuthLogout
    };

    use app\admin\entry\{
        EntryAdmin,
        EntryAdminDelete,
        EntryAdminCreate
    };
    use app\admin\comment\{
        CommentAdmin,
        CommentAdminDelete,
        CommentAdminCreate
    };
    use app\admin\user\{
        UserAdmin,
        UserCreate,
        UserAdminDelete
    };

   class Events extends QModel{

   }
    class AuthMiddleware{

    }
    class Admin extends QController{
        public $db;
        public function __construct(){
            parent::__construct();
            $this->authencation = true;

        }
        public function get(){
            return $this->get_template('admin/index');
        }
        public function usersCount(){
            $user = $this->db->query(new Users);
            return $user->count();
        }
        public function entriesCount(){
            $entry = $this->db->query(new Entry);
            return $entry->count();
        }
        public function commentsCount(){
            $comment = $this->db->query(new Comment);
            return $comment->count();
        }
    }   
   
   class Home extends QController{
        public function __construct(){
            $model = new Events();
        }
        public function get(){
            return  $this->get_template('index');
        }
   }
   class Contact extends QController{
        public function __construct(){
            $model = new Events();
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
    $app->route->add('#^/admin/user/create$#', new UserCreate, "admin_user_create", array(
                'GET', 'POST'
            ));
    $app->route->add('#^/admin/user/edit/{id}$#', new UserCreate, "admin_user_edit", array(
                'GET', 'POST'
            ));
    $app->route->add('#^/admin/user/delete/{id}$#', new UserAdminDelete, "admin_user_delete", array(
                'GET', 'POST'
            ));
    $app->route->add('#^/admin/entries$#', new EntryAdmin, "admin_entry", array(
                'GET', 'POST'
            ));
    $app->route->add('#^/admin/entry/create$#', new EntryAdminCreate, "admin_entry_create", array(
                'GET', 'POST'
            ));
    $app->route->add('#^/admin/entry/edit/{id}$#', new EntryAdminCreate, "admin_entry_edit", array(
                'GET', 'POST'
            ));
    $app->route->add('#^/admin/entry/delete/{id}$#', new EntryAdminDelete, "admin_entry_delete", array(
                'GET', 'POST'
            ));
    //comments routes injections
    $app->route->add('#^/admin/comments$#', new CommentAdmin, "admin_comment", array(
                'GET', 'POST'
            ));
    $app->route->add('#^/admin/comment/create$#', new CommentAdminCreate, "admin_comment_create", array(
                'GET', 'POST'
            ));
    $app->route->add('#^/admin/comment/edit/{id}$#', new CommentAdminCreate, "admin_comment_edit", array(
                'GET', 'POST'
            ));
    $app->route->add('#^/admin/comment/delete/{id}$#', new CommentAdminDelete, "admin_comment_delete", array(
                'GET', 'POST'
            ));
    $app->route->add('#^/auth/login$#', new AuthLogin, "auth_login", array(
                'GET', 'POST'
            ));
    
    $app->route->add('#^/auth/logout$#', new AuthLogout, "auth_logout", array(
                'GET',
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