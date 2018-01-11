<?php
// replaced self:: to static::;
class Db_object
{
    protected static $db_table = 'users';

    public static function find_all()
    {
        $query_users = "SELECT * FROM " . static::$db_table . " ";
        return static::find_this_query($query_users);
    }

    public static function find_by_id($user_id)
    {
        $query_user_id = "SELECT * FROM " . static::$db_table . " WHERE id = $user_id LIMIT 1";
        $the_result_array = static::find_this_query($query_user_id);
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }

    public static function find_this_query($sql)
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
}