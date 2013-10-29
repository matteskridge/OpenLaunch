<?php

class InputField {
    protected $name, $display, $value, $id, $valid, $form, $example, $force = null;

    public function __construct($name, $display, $value = "", $valid = array(), $example = "") {
        $this->name = $name;
        $this->display = $display;
        $this->value = $value;
        $this->valid = $valid;
		$this->example = $example;
		$this->init();
    }

	public function init() {}

    public function getName() {
        return $this->name;
    }

    public function getDisplay() {
        return $this->display;
    }

    public function getValue() {
		if ($this->force != null) return $this->force;
        if (isset($_POST[$this->id]))
            return $_POST[$this->id];
        else
            return "";
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function isValid($data, $requirement) { return true; }

    public function meetsRequirements() {
        $data = $this->getValue();
		if (!$this->isValid($data, "")) return false;
        foreach ($this->valid as $requirement) {
			$value = $this->isValid($data, $requirement);
            if (!$value) return false;
        }
        return true;
    }

    public function setForm($form) {
        $this->form = $form;
        $this->id = $form->getName()."-".$this->name;
    }
}