<?php

class Model {
    private $row;
    protected $id;

	public function run($name) {
		if ($name == "platform.start.3") {
			foreach (Platform::getSolutions("Models") as $solution) {
				foreach ($solution->getFile()->listSubs() as $model) {
					$model->import();
				}
			}
		}
	}

    public function onCreate($data) {}
    public function onDestroy() {}

    public function __construct($id = null, $what = "") {
		if ($id == null) return;
		if ($what == "") $what = get_class($this);

        if ($id instanceof DatabaseRow) {
            $this->row = $id;
            $this->id = $this->row->get("id");
            return;
        } else if ($id instanceof Model) {
            $id = $id->get("id");
        }

        if (is_array($id)) {
            $row = Database::select($what, $id);
        } else {
            $row = Database::select($what, array("id" => $id));
        }

        if (count($row) > 0) {
            $row = $row[0];
            $this->row = $row;
            $this->id = $row->get("id");
        } else {
            $this->row = null;
            $this->id = 0;
        }
    }

    public static function create($what, $data) {
        $what = ucfirst($what);

        foreach (Platform::listModels() as $model) {
            if ($model == $what) {
                $structure = call_user_func_array(array(new $what(), "getStructure"), array());
                $put = array();

                foreach ($structure as $col => $type) {

					if (key_exists($col, $data)) {
						if (in_array($type, self::$listTypes)) {
							$put[$col] = implode(self::$listDelim, $data[$col]);
						} else {
							$put[$col] = $data[$col];
						}
					} else {
						$put[$col] = "";
					}

                }

                $put["cs_created"] = time();
                $put["cs_modified"] = time();
                Database::insert($what, $put);
                $m = new $what(mysql_insert_id());
                $m->onCreate($data);
                return $m;
            }
        }
    }

    public static function find($what, $id) {
        $what = ucfirst($what);

        foreach (Platform::listModels() as $model) {
            if ($model == $what) {
                return new $what($id);
            }
        }
    }

    public static function findAll($what, $arr = array(), $order = "", $page = 0, $pagesize = 20) {
        $what = ucfirst($what);

        $limit = "";
        if ($page != 0) {
            $lastpage = Database::count($what, $arr);
            $lastpage = ($lastpage == 0)?1:(ceil($lastpage/$pagesize));

            if (!is_numeric($page)) {
                $page = 1;
            } else if ($page > $lastpage) {
                $page = $lastpage;
            }

            $min = ($page*$pagesize)-$pagesize;
            $max = ($page*$pagesize);

            $limit = "$min,$max";
        }

        foreach (Platform::listModels() as $model) {
            if ($model == $what) {
                if (is_array($arr)) {
                    foreach ($arr as $k => $v) {
                        if ($v instanceof Model) {
                            $arr[$k] = $v->get("id");
                        }
                    }
                }

                $models = Database::select($what, $arr, $order, $limit);
                $arr = array();
                foreach ($models as $m) {
                    array_push($arr, new $what($m->get("id")));
                }
                return $arr;
            }
        }
    }

	public static function count($what, $arr = array(), $distinct = "") {
		$what = ucfirst($what);

        foreach (Platform::listModels() as $model) {
            if ($model == $what) {
                if (is_array($arr)) {
                    foreach ($arr as $k => $v) {
                        if ($v instanceof Model) {
                            $arr[$k] = $v->get("id");
                        }
                    }
                }

                return Database::count($what, $arr, $distinct);
            }
        }
	}

    public static function search($what, $query) {
        $what = ucfirst($what);

        foreach (Platform::listModels() as $model) {
            if ($model == $what) {
                $instance = new $what();
                if (method_exists($instance, "searchColumns")) {
                    $columns = $instance->searchColumns();
                } else {
                    $columns = array("name");
                }

                $q = array();
                foreach ($columns as $col) {
                    $q[$col] = $query;
                }

                $match = Database::search($what, $q);
                $ret = array();
                foreach ($match as $m) {
                    array_push($ret, new $what($m));
                }

                return $ret;
            }
        }
    }

    public function getStructure() {}

    private static $stringTypes = array("string", "string+");
    private static $numberTypes = array("number");
    private static $intTypes = array("integer");
    private static $booleanTypes = array("boolean");
    private static $listTypes = array("list");
    private static $mapTypes = array("map");
    private static $listDelim = "[AND]";
    private static $mapDelim1 = "[AND]";
    private static $mapDelim2 = "[to]";

    public function get($key) {
		if (!$this->exists()) {
			return "";
		}

        if ($key == "cs_created" || $key == "cs_modified") {
            return $this->row->get($key);
        }
        $struct = $this->getStructure();

        if (array_key_exists($key, $struct) || $key == "id") {
            $type = (key_exists($key, $struct))? $struct[$key]: "";
            if ($key == "id") {
                return $this->row->get($key);
            } else if (in_array($type, self::$stringTypes)) {
                return $this->row->get($key);
            } else if (in_array($type, self::$numberTypes)) {
                return $this->row->get($key);
            } else if (in_array($type, self::$intTypes)) {
                return $this->row->get($key);
            } else if (in_array($type, self::$booleanTypes)) {
                return $this->row->get($key);
            } else if (in_array($type, self::$listTypes)) {
                $list = explode(self::$listDelim, $this->row->get($key));
                if ($this->row->get($key) == "") return array();
                return $list;
            } else if (in_array($type, self::$mapTypes)) {
                $list = explode(self::$mapDelim1, $this->row->get($key));
                $arr = array();
                foreach ($list as $l) {
                    $bits = explode(self::$mapDelim2, $l);
                    $arr[$bits[0]] = $bits[1];
                }
                return $arr;
            } else {
                return new $type($this->row->get($key));
            }
        } else {
            return "";
        }
    }

    public function set($key, $value = "") {
        if (!is_array($key)) {
            $key = array($key => $value);
        }

        foreach ($key as $k => $v) {
            $struct = $this->getStructure();
            if (!array_key_exists($k, $struct)) {
                unset($key[$k]);
                continue;
            }
            $type = $struct[$k];

            if (in_array($type, self::$stringTypes)) {

            } else if (in_array($type, self::$numberTypes)) {

            } else if (in_array($type, self::$intTypes)) {

            } else if (in_array($type, self::$booleanTypes)) {

            } else if (in_array($type, self::$listTypes)) {
                $key[$k] = implode(self::$listDelim, $v);
            } else if (in_array($type, self::$mapTypes)) {
                $arr = array();
                foreach ($key[$k] as $k2 => $v2) {
                    array_push($arr, "$k2".self::$mapDelim2."$v2");
                }
                $key[$k] = implode(self::$mapDelim1, $arr);
            } else if ($v instanceof Model) {
                $key[$k] = $v->get("id");
            } else {

			}
			$this->row[$k] = $key[$k];
        }

        Database::set(get_class($this), array("id" => $this->id), $key);
    }

    public static function getSQLType($type) {
        if (in_array($type, self::$stringTypes)) {
            if ($type == "string+") return "TEXT";
            return "VARCHAR(128)";
        } else if (in_array($type, self::$numberTypes)) {
            return "DOUBLE";
        } else if (in_array($type, self::$intTypes)) {
            return "INT(32)";
        } else if (in_array($type, self::$booleanTypes)) {
            return "INT(1)";
        } else if (in_array($type, self::$listTypes)) {
            return "VARCHAR(20000)";
        } else if (in_array($type, self::$mapTypes)) {
            return "VARCHAR(20000)";
        } else {
            return "INT(11)";
        }
    }

    public function exists() {
        return $this->row != null;
    }

    public function delete() {
        Database::remove(get_class($this), array("id" => $this->id));
    }

    public function getCreated() {
		return relativeDateHtml($this->get("cs_created"));
    }

    public function getId() {
        return $this->id;
    }

	public function __toString() {
		return $this->id;
	}

    public function remove() {
        $this->delete();
    }

	public function modified() {
		Database::set(get_class($this), array("id" => $this->id), array("cs_modified" => time()));
	}
}

function relativeDate($time) {
	$diff = time()-$time;

	if ($diff < 60)
		return "moments ago";
	else if ($diff < 120)
		return "one minute ago";
	else if ($diff < 60*60)
		return floor($diff/60)." minutes ago";
	else if ($diff < 60*60*2)
		return "one hour ago";
	else if ($diff < 86400)
		return floor($diff/60/60)." hours ago";
	else if ($diff < 86400*2)
		return "one day ago";
	else if ($diff < 86400*30)
		return floor($diff/86400)." days ago";
	else if ($diff < 86400*30*2)
		return "one month ago";
	else if ($diff < 86400*365)
		return floor($diff/86400/30)." months ago";
	else
		return floor($diff/86400/365)." years ago";
}

function absoluteDate($time) {
	return date("F d Y. h:i", $time);
}

function relativeDateHtml($time) {
	return "<span title='".absoluteDate($time)."'>".relativeDate($time)."</span>";
}