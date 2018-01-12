<?php

// replaced   to static::;
class Db_object
{
    protected static $db_table = 'users';

    public static function find_all()
    {
        $query_all = "SELECT * FROM " . static::$db_table . " ";
        return static::find_by_query($query_all);
    }

    public static function find_by_id($user_id)
    {
        $query_id = "SELECT * FROM " . static::$db_table . " WHERE id = $user_id LIMIT 1";
        $the_result_array = static::find_by_query($query_id);
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }

    public static function find_by_query($sql)
    {
        global $database;
        $result_set = $database->query($sql);
        $the_object_array = array();
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
            die('Query failed' . mysqli_error($database->connection));
        }
    }

    public function update()
    {
        global $database;
        $properties = $this->clean_properties();
        $properties_pairs = [];
        foreach ($properties as $key => $value) {
            $properties_pairs = "{$key}='{$value}'";
        }
        $sql = "UPDATE users SET username = '" . $database->escape_string($this->username) . "',
                                password = '" . $database->escape_string($this->password) . "',
                                first_name = '" . $database->escape_string($this->first_name) . "',
                                last_name = '" . $database->escape_string($this->last_name) . "'
                                WHERE id =  {$database->escape_string($this->id)}";

//        $sql = "UPDATE " . self::$db_table . " SET " . implode(',', $properties_pairs) . " WHERE id = {$database->escape_string($this->id)}";

        $database->query($sql);
        return (mysqli_affected_rows($database->connection) == 1) ? true : die('Query failed' . mysqli_error($database->connection));
    }


    public function delete()
    {
        global $database;
        $sql = "DELETE FROM " . static::$db_table . " WHERE id = {$database->escape_string($this->id)} LIMIT 1";
        $database->query($sql);
        return (mysqli_affected_rows($database->connection) == 1) ? true : die('Query failed' . mysqli_error($database->connection));
    }

}