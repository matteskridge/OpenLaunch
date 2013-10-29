<?php

/* =================================
 * CreationShare Platform
 *
 * (c) CreationShare Technology LLC
 * =================================
 */

class AntispamField extends InputField {
    public function __construct($name) {
        parent::__construct($name, "", "", array("nobot"));
    }

    public function getHtml() {
        if (!isset($_SESSION["cs_spamcode"])) {
            $_SESSION["cs_spamcode"] = mt_rand(1,100);
        }
        return Component::get("Antispam", array("id" => $this->id));
    }

    public function getValue() {
        return $_POST[$this->id];
    }

    public function isValid($data, $requirement) {
        return ($data == $_SESSION["cs_spamcode"]);
        return true;
    }
}