<?php

class RolesPermissionField extends InputField {
	private $options;

	public function init() {
		$arr = array();
		foreach (Role::findAll("Role") as $role) {
			$arr[$role->get("id")] = $role->get("name");
		}
		$this->options = $arr;
	}

	public function getHtml() {
		$text = "";

        if ($this->display)
            $text .= "<label for='$this->id'>$this->display</label>";

		if (is_array($this->value) && count($this->value) == 0) {
			$extra = " class='checked'";
		} else $extra = "";

        $text .= "<div class='listboxwrap rolespermissionfield'><div class='listboxmain'>";
		$text .= "<div><input type='checkbox' id='$this->id' name='$this->id' value='1'$extra /> <label for='$this->id'>Everyone</label></div>";
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