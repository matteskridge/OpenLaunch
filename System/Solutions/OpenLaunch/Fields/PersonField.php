<?php

/* =================================
 * CreationShare Platform
 *
 * (c) CreationShare Technology LLC
 * =================================
 */

class PersonField extends InputField {
    public function getHtml() {
        return Component::get("CreationShare.PersonField", array("name" => $this->display, "id" => $this->id, "value" => $this->value));
    }

    public function getValue() {
        if (isset($_POST[$this->id]) && $_POST[$this->id] != "") {
            return new Person($_POST[$this->id]);
        } else {
            $user = Person::search("Person", $_POST[$this->id."-main"]);
            $user = $user[0];
            return $user;
        }
    }
}

