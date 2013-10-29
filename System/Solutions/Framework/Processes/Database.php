<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Database {
    private static $ip, $url, $queries, $cache;

    public static function run($event) {
        if ($event == "platform.start.2") {
            self::start();
        }
    }

    public static function start() {
        mysql_connect(
            Settings::get("database.server"),
            Settings::get("database.user"),
            Settings::get("database.password")
        );
        mysql_select_db(Settings::get("database.name"));

        self::$queries = array();
        self::$cache = array();
    }

    public static function query($q, $table = "") {
        if (array_key_exists($q, self::$cache)) {
            return self::$cache[$q];
        }
        $result = mysql_query($q) or die(mysql_error());
        array_push(self::$queries, new QueryRecord($q));

        if (!$result) {
            return array();
        }

        $arr = array();
        while ($row = mysql_fetch_assoc($result)) {
            $r = new DatabaseRow($row, $table);
            array_push($arr, $r);
        }

        self::$cache[$q] = $arr;
        return $arr;
    }

    public static function clearCache() {
        self::$cache = array();
    }

    public static function select($table, $where = array(), $order = "", $limit = "") {
        $find = "WHERE ";
        $done = false;

        if ($where == array()) {
            $find .= "1=1";
        } else if (!is_array($where)) {
            $find .= $where;
        } else {
            foreach ($where as $key => $value) {
                if ($done) $find .= " AND ";

                if (is_numeric($key)) {
                    $find .= $value;
                } else {
                    $value = Security::prepareForDatabase($value);
                    $find .= "`$key`='$value'";
                }

                $done = true;
            }
        }

        $q = "SELECT * FROM `$table` $find";

        if ($order != "") {
            $q .= " ORDER BY $order";
        }
        if ($limit != "") {
            $limit = Security::prepareForDatabase($limit);
            $q .= " LIMIT $limit";
        }

        return self::query($q, $table);
    }

    public static function search($table, $where, $require = array(), $order = "", $limit = "") {
        $find = "WHERE (";
        $done = false;

        if ($where == array()) {
            $find .= "1=1";
        } else {
            foreach ($where as $key => $value) {
                $key = Security::prepareForDatabase($key);
                $value = Security::prepareForDatabase($value);
                if ($done) $find .= " OR ";
                $find .= "`$key` LIKE '%$value%'";
                $done = true;
            }
        }

        $find .= ")";
        if (count($require) > 0) {
            foreach ($require as $key => $value) {
                $key = Security::prepareForDatabase($key);
                $value = Security::prepareForDatabase($value);
                $find .= " && `$key`='$value'";
            }
        }

        $q = "SELECT * FROM `$table` $find";

        if ($order != "") {
            $q .= " ORDER BY $order";
        }
        if ($limit != "") {
            $q .= " LIMIT $limit";
        }

        return self::query($q, $table);
    }

    public static function count($table, $where, $distinct = "") {
        $find = "WHERE (";
        $done = false;

        if ($where == array()) {
            $find .= "1=1";
        } else if (!is_array($where)) {
            $find .= $where;
        } else {
            foreach ($where as $key => $value) {
                if ($done) $find .= " AND ";

                if (is_numeric($key)) {
                    $find .= $value;
                } else {
                    $value = Security::prepareForDatabase($value);
                    $find .= "`$key`='$value'";
                }

                $done = true;
            }
        }

        $find .= ")";

		$dist = ($distinct == "")?"*":"distinct $distinct";
        $q = "SELECT COUNT($dist) FROM `$table` $find";
		if ($group != "") $q .= " GROUP BY $group";
        $result = mysql_query($q);

        if ($result) {
            $result = mysql_fetch_assoc($result);
            return array_pop($result);
        } else {
            return 0;
        }
    }

    public static function execute($query) {
        return mysql_query($query) or die("Query: $query,".mysql_error());
    }

    public static function getQueriesHTML() {
        $html = "";
        foreach (self::$queries as $key => $value) {
            $html .= "<div>[".$value->getTime()."] ".$value->getQuery()."</div>";
        }
        return $html;
    }

    public static function insert($table, $contents, $slow = false) {
        $text = ($slow)? "INSERT INTO `$table` (": "INSERT INTO `$table` (";
        $done = false;

        foreach ($contents as $key => $value) {
            if ($done) $text .= ",";
            $text .= "`$key`";
            $done = true;
        }

        $text .= ") VALUES(";
        $done = false;
        foreach ($contents as $key => $value) {
            if ($done) $text .= ",";
            $text .= "'".Security::prepareForDatabase($value)."'";
            $done = true;
        }

        $text .= ")";

        self::execute($text);
        return mysql_insert_id();
    }

    public static function set($table, $find, $update) {
        $set = "";
        $done = false;
        foreach ($update as $key => $value) {
            if ($done) $set .= ",";
            $set .= "`$key`='".Security::prepareForDatabase($value)."'";
            $done = true;
        }

        $where = "";
        $done = false;
        foreach ($find as $key => $value) {
            if ($done) $where .= " AND ";
            $where .= "`$key`='".Security::prepareForDatabase($value)."'";
            $done = true;
        }

        if ($set != "") {
            $text = "UPDATE `$table` SET $set WHERE $where";
            self::execute($text);
        }
    }

    public static function remove($table, $find) {
        $where = "";
        $done = false;
        foreach ($find as $key => $value) {
            if ($done) $where .= " AND ";
            $where .= "`$key`='".Security::prepareForDatabase($value)."'";
            $done = true;
        }

        $text = "DELETE FROM `$table` WHERE $where";
        self::execute($text);
    }

    public static function numberOfQueries() {
        return count(self::$queries);
    }

    public static function getDatabaseStructure() {
        $result = mysql_query("SHOW TABLES FROM ".Settings::get("database.name"));
        $text = "";
        $queries = array();

        while ($row = mysql_fetch_row($result)) {
            $name = $row[0];

            $create = "SHOW CREATE TABLE ".Settings::get("database.name").".$name";
            $cresult = mysql_query($create);

            while ($table_def = mysql_fetch_row($cresult)) {
                for ($i=1; $i<count($table_def); $i++) {
                    array_push($queries, $table_def[$i]."\n");
                }
            }
        }

        return $queries;
    }
}

class QueryRecord {
    private $query;
    private $time;

    public function __construct($q) {
        $this->query = $q;
        $this->time = microtime(true);
    }

    public function getQuery() {
        return $this->query;
    }

    public function getTime() {
        return $this->time;
    }
}

class DatabaseRow extends ArrayObject {
    private $table;
    private $row;

    public function __construct($row, $table = "") {
        $this->table = $table;
        $this->row = $row;
    }

    public function get($name) {
        if (!array_key_exists($name, $this->row)) return "";
        return $this->row[$name];
    }

    public function set($key, $value) {
        $this->row[$key] = $value;
    }

    public function containsKey($key) {
        return array_key_exists($key, $this->row);
    }

    public function getTable() {
        return $this->table;
    }

    function offsetGet($i) {
        return $this->row[$i];
    }
}
