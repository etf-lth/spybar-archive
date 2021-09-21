<?php

class DBConnection extends Mysqli {

    function __construct($host, $username, $password, $database) {
        try{
            parent::__construct($host, $username, $password, $database);
            $this->set_charset("utf8");

            if ($this->connect_error) {
                throw new exception('Database Connection Error: '.$this->connect_error);
            }
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    function refValues($arr) {
        $refs = array();
        foreach ($arr as $key => $value)
            $refs[$key] = &$arr[$key];
        return $refs;
    }

    function pquery($query, $params = NULL, $close = TRUE) {
        if ($stmt = $this->prepare($query)) {

            if ($params != NULL)
                call_user_func_array(array($stmt, 'bind_param'), $this->refValues($params));

            $stmt->execute();

            if ($close) {
                $affected = $stmt->affected_rows;
                $stmt->close();
                return $affected;
            } else {
                return $stmt;
            }

        } else die('DBConnection: fetch failed: '.$this->error);
    }

    function fetch($query, $params = NULL, $class_name = "stdClass") {
        $stmt = $this->pquery($query, $params, FALSE);

        $meta = $stmt->result_metadata();

        while ($field = $meta->fetch_field()) {
            $parameters[] = &$row[$field->name];
        }

        call_user_func_array(array($stmt, 'bind_result'), $this->refValues($parameters));

        $results = array();
        while ($stmt->fetch()) {
            $x = new $class_name;
            foreach ($row as $key => $val) {
                $x->$key = $val;
            }
            $results[] = $x;
        }

        $stmt->close();
        return $results;
    }

    function fetch_one($query, $params = NULL,$class_name="stdClass") {
        $stmt = $this->pquery($query, $params, FALSE);

        $meta = $stmt->result_metadata();

        while ($field = $meta->fetch_field()) {
            $parameters[] = &$row[$field->name];
        }

        call_user_func_array(array($stmt, 'bind_result'), $this->refValues($parameters));

        $result = null;
        if ($stmt->fetch()) {
            $result = new $class_name;
            foreach ($row as $key => $val) {
                $result->$key = $val;
            }
        }

        $stmt->close();
        return $result;
    }
}

?>
