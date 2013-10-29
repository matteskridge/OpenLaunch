<?php

/* =================================
 * CreationShare Platform
 *
 * (c) CreationShare Technology LLC
 * =================================
 */

class SelectField extends InputField {
    protected $options;

    public function __construct($name = "", $display = "", $value = "", $options = array(), $example = "") {
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

        $text .= "<div class='selectbox'>";
        $text .= "<select id='$this->id' name='$this->id'>";
        foreach ($this->options as $key => $value) {
            $extra = "";
            if ($key == $this->value || ($this->value instanceof Model && $this->value->get("id") == $key)) {
                $extra = " selected='yes'";
            }
            $text .= "<option value='$key'$extra>$value</option>";
        }
        $text .= "</select>";
        $text .= "</div>";
        return $text;
    }

	public function checkValid($data, $requirement = "") {
		return array_key_exists($data, $this->options);
	}
}

?>