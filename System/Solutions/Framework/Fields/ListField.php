<?php

class ListField extends InputField {
    protected $options;

    public function __construct($name, $display, $value, $options = array(), $example = "") {
        $this->name = $name;
        $this->value = $value;
        $this->options = $options;
        $this->display = $display;
        $this->valid = array();
		$this->example = $example;
		$this->init();
    }

    public function getHtml() {
		$text = "";

		if ($this->display)
			$text .= "<label for='$this->id'>$this->display</label>";

		$text .= "<div class='listboxwrap'><div class='listboxmain'>";
		foreach ($this->options as $key => $value) {
			$extra = "";
			if ((is_array($this->value) && in_array($key, $this->value)) || (!is_array($this->value) && $this->value == $key)) {
				$extra = " checked='yes'";
			}
			$text .= "<div><input type='checkbox' id='$this->id-$key' name='$this->id-$key' value='1'$extra> <label for='$this->id-$key'>$value</label></div>";
		}
		$text .= "</div></div>";
		return $text;
    }

	public function isValid($data, $requirement) { return true;
		foreach ($this->data as $item) {
			if (!in_array($item, $this->data)) return false;
		}
		return true;
	}

	public function getValue() {
		$arr = array();
		foreach ($this->options as $key => $value) {
			if (isset($_POST["$this->id-$key"]) && $_POST["$this->id-$key"] == "1") array_push($arr, $key);
		}
		return $arr;
	}
}

?>