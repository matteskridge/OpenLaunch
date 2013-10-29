<?php

/* =================================
 * CreationShare Platform
 *
 * (c) CreationShare Technology LLC
 * =================================
 */

class TextField extends InputField {
    protected $type = "text", $start = "", $end = "", $classes = "";

	public function getClasses() {
		$classes = "";
		foreach ($this->valid as $valid) {
			if ($valid == "email") $classes .= " forceemail";
			else if ($valid == "password") $classes .= " forcepassword";
			else if ($valid == "empty") $classes .= " forceempty";
			else if ($valid == "noempty") $classes .= " forcenoempty";
			else if ($valid == "zipcode") $classes .= " forcezipcode";
			else if ($valid == "float") $classes .= " forcefloat";
			else if ($valid == "integer") $classes .= " forceinteger";
			else if ($valid == "ip") $classes .= " forceip";
			else if ($valid == "url") $classes .= " forceurl";
			else if ($valid == "phone") $classes .= " forcephone";
			else if ($valid == "link") $classes .= " forcelink";
			else if ($valid == "alpha") $classes .= " forcealpha";
			else if (strstr($valid, "length:")) $classes .= " forcelength";
			else if (strstr($valid, "equals:")) $classes .= " forcequals";
		}
		return $classes;
	}

	public function getMin() {
		$min = null;
		foreach ($this->valid as $valid) {
			if (strstr($valid, "length:")) {
				$bits = explode(",", str_replace("length:", "", $valid));
				if (count($bits) > 0) $min = $bits[0];
			}
		}
		return $min;
	}

	public function getMax() {
		$max = null;
		foreach ($this->valid as $valid) {
			if (strstr($valid, "length:")) {
				$bits = explode(",", str_replace("length:", "", $valid));
				if (count($bits) > 1) $max = $bits[1];
			}
		}
		return $max;
	}

	public function getEquals() {
		foreach ($this->valid as $valid) {
			if (strstr($valid, "equals:")) {
				return str_replace("equals:", "", $valid);
			}
		}
		return null;
	}

    public function getHtml() {
		$classes = "";
		$min = $this->getMin();
		$max = $this->getMax();
		$equals = $this->getEquals();
		$classes .= $this->getClasses();

		$other = "";
		if ($min != null) $other .= " data-minlength='$min'";
		if ($max != null) $other .= " maxlength='$max'";
		if ($equals != null) $other .= " data-equals='".$this->form->getName()."-$equals'";
		if ($this->start != "" || $this->end != "") $other .= " style='width:200px;'";

        $text = "<label for='$this->id'>$this->display</label>";
        $text .= "$this->start<input class='textfield validate $classes$this->classes' type='$this->type' id='$this->id' name='$this->id' value='$this->value'$other />$this->end";
		$text .= "<span class='formexample'>$this->example</span>";
        return $text;
    }

    public function isValid($data, $requirement) {
        if ($requirement == "notempty") {
            return strlen($data) != 0;
        } else if ($requirement == "empty") {
            return strlen($data) == 0;
        } else if (strstr($requirement, "length:")) {
            $str = str_replace("length:", "", $requirement);
            $bits = explode(",", $str);
            $min = $bits[0];
            $max = $bits[1];
            $actual = strlen($data);

            if ($min == "" || $min > $actual) {
                return false;
            }
            if ($max == "" || $max < $actual) {
                return false;
            }

			return true;
		} else if ($requirement == "zipcode") {
			return (is_numeric($data) && strlen($data) == 5);
		} else if ($requirement == "email") {
			return filter_var($data, FILTER_VALIDATE_EMAIL);
		} else if ($requirement == "float") {
			return filter_var($data, FILTER_VALIDATE_FLOAT);
		} else if ($requirement == "integer") {
			return filter_var($data, FILTER_VALIDATE_INT);
		} else if ($requirement == "ip") {
			return filter_var($data, FILTER_VALIDATE_IP);
		} else if ($requirement == "url") {
			return filter_var($data, FILTER_VALIDATE_URL);
		} else if ($requirement == "phone") {
			$value = preg_replace("/[^0-9]*/", "", $data);
			if (strlen($value) == 11 || strlen($value) == 10) return $value; else return false;
		} else if ($requirement == "alphanum") {
			return preg_match("/([a-zA-Z0-9]+)/", $data);
		} else if ($requirement == "password") {
			return strlen($data) <= Security::maximumPasswordLength() && strlen($data) >= Security::minimumPasswordLength();
        } else {
            return true;
		}
    }
}