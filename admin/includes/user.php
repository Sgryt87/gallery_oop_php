<?php

class User extends Db_object
{
    protected static $db_table = 'users';
    protected static $db_table_fields = ['username', 'password', 'first_name', 'last_name', 'user_image'];

    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $user_image;
    public $upload_directory = 'images';
    //public $image_placeholder = 'http://placehold.it/80x80&text=image';
    public $image_placeholder = 'images/user.png';


// need to abstract the method replacing filename to user_image //
//    public function save()
//    {
//        if (!empty($this->errors)) {
//            return false;
//        }
//        if (empty($this->user_image) || empty($this->tmp_path)) {
//            $this->errors[] = 'The file was not available';
//            return false;
//        }
//        $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->user_image;
//        if (file_exists($target_path)) {
//            $this->errors[] = "The file {$this->user_image} already exists";
//            return false;
//        }
//        if (move_uploaded_file($this->tmp_path, $target_path)) {
//            if ($this->create()) {
//                unset($this->tmp_path);
//                return true;
//            }
//        } else {
//            $this->errors[] = 'The file directory probably does not have a permission';
//            return false;
//        }
//    }

    public function upload_photo()
    {
        if (!empty($this->errors)) {
            return false;
        }
        if (empty($this->user_image) || empty($this->tmp_path)) {
            $this->errors[] = 'The file was not available';
            return false;
        }
        $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->user_image;
        if (file_exists($target_path)) {
            $this->errors[] = "The file {$this->user_image} already exists";
            return false;
        }
        if (move_uploaded_file($this->tmp_path, $target_path)) {

            unset($this->tmp_path);
            return true;

        } else {
            $this->errors[] = 'The file directory probably does not have a permission';
            return false;
        }
    }

    public function image_path_and_placeholder()
    {
        return empty($this->user_image) ? $this->image_placeholder : $this->upload_directory . DS . $this->user_image;
    }

    public static function verify_user($username, $password)
    {
        global $database;
        $username = $database->escape_string($username);
        $password = $database->escape_string($password);

        $sql = "SELECT * FROM " . static::$db_table . " WHERE username = '{$username}' AND password = '{$password}' LIMIT 1";

        $the_result_array = static::find_by_query($sql);
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }

    public function ajax_save_user_image($user_image, $user_id)
    {
        global $database;
        $user_image = $database->escape_string($user_image);
        $user_id = $database->escape_string($user_id);

        $this->user_image = $user_image;
        $this->id = $user_id;

        $sql = "UPDATE " . self::$db_table . " SET user_image='{$this->user_image}' WHERE id = {$this->id}";
        $update_image = $database->query($sql);
        //display image without reloading the page.
        echo $this->image_path_and_placeholder();
    }
}


