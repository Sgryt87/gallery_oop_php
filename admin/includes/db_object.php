<?php

// replaced   to static::;
class Db_object
{
    public $errors = [];
    public $upload_errors_array =
        [
            UPLOAD_ERR_OK => 'There is no error, the file uploaded with success.',
            UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload max file size.',
            UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the max file size.',
            UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
            UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.'
        ];

    protected static $db_table = '';

    public function set_file($file)
    {
        if (empty($file) || !$file || !is_array($file)) {
            $this->errors[] = 'There was no file uploaded here';
            return false;
        } elseif ($file['error'] != 0) {
            $this->errors[] = $this->upload_errors_array[$file['error']];
            return false;
        } else {
            $this->user_image = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
            $this->type = $file['type'];
            $this->size = $file['size'];
        }
    }

    public static function find_all()
    {
        $query_all = "SELECT * FROM " . static::$db_table . "";
        return static::find_by_query($query_all);
    }

    public static function find_by_id($id)
    {
        $query_id = "SELECT * FROM " . static::$db_table . " WHERE id = $id LIMIT 1";
        $the_result_array = static::find_by_query($query_id);
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }

    public static function find_by_query($sql)
    {
        global $database;
        $result_set = $database->query($sql);
        $the_object_array = [];
        while ($row = mysqli_fetch_array($result_set)) {
            $the_object_array[] = static::instantiation($row);
        }
        return $the_object_array;
    }

    public static function instantiation($the_record)
    {
        $calling_class = get_called_class();
        // replaced $the_object = new self to $calling_class;
        $the_object = new $calling_class;
        foreach ($the_record as $the_attribute => $value) {
            if ($the_object->has_the_attribute($the_attribute)) {
                $the_object->$the_attribute = $value;
            }
        }
        return $the_object;
    }

    private function has_the_attribute($the_attribute)
    {
        $object_properties = get_object_vars($this);
        return array_key_exists($the_attribute, $object_properties);
    }

    protected function properties()
    {
        $properties = [];
        foreach (static::$db_table_fields as $db_field) {
            if (property_exists($this, $db_field)) {
                $properties[$db_field] = $this->$db_field;
            }
        }
        return $properties;
    }

    protected function clean_properties()
    {
        global $database;
        $clean_properties = [];
        foreach ($this->properties() as $key => $value) {
            $clean_properties[$key] = $database->escape_string($value);
        }
        return $clean_properties;
    }

    public function save()
    {
        return isset($this->id) ? $this->update() : $this->create();
    }

    public function create()
    {
        global $database;
        $properties = $this->clean_properties();
        $sql = "INSERT INTO " . static::$db_table . "(" . implode(',', array_keys($properties)) . ") 
                VALUES('" . implode("','", array_values($properties)) . "')";

        if ($database->query($sql)) {
            $this->id = $database->the_insert_id();
            return true;
        } else {
            die('Query failed 1' . mysqli_error($database->connection));
        }
    }

    public function update()
    {
        global $database;
        $properties = $this->clean_properties();
        $properties_pairs = [];
        foreach ($properties as $key => $value) {
            $properties_pairs[] = "{$key}='{$value}'";
        }
//        $sql = "UPDATE users SET username = '" . $database->escape_string($this->username) . "',
//                                password = '" . $database->escape_string($this->password) . "',
//                                first_name = '" . $database->escape_string($this->first_name) . "',
//                                last_name = '" . $database->escape_string($this->last_name) . "'
//                                WHERE id =  {$database->escape_string($this->id)}";


        $sql = "UPDATE " . static::$db_table . " SET " . implode(',', $properties_pairs) . " WHERE id =
         {$database->escape_string($this->id)}";

        $database->query($sql);
        return (mysqli_affected_rows($database->connection) == 1) ? true : die('Query failed 2' . mysqli_error
            ($database->connection));
    }


    public function delete()
    {
        global $database;
        $sql = "DELETE FROM " . static::$db_table . " WHERE id = {$database->escape_string($this->id)} LIMIT 1";
        $database->query($sql);
        return (mysqli_affected_rows($database->connection) == 1) ? true : die('Query failed 3' . mysqli_error
            ($database->connection));
    }

}