<?php

class Form {
    private $name, $items, $model, $submit;

	public function run($name) {
		if ($name == "platform.start.7") {
			$this->importFields();
		}
	}

	public function importFields() {
		$f = new File("System/Solutions/CreationShare/Fields/TextField.php"); $f->import();
		$f = new File("System/Solutions/CreationShare/Fields/SelectField.php"); $f->import();

		foreach (Platform::getSolutions("Fields") as $solution) {
			foreach ($solution->getFile()->listSubs() as $sub) {
				$sub->import();
			}
		}
	}

    public function __construct($name = "", $submit = "Apply Changes") {
        $this->name = $name;
        $this->items = array();
        $this->submit = $submit;
    }

    public function add($input) {
        $input->setForm($this);
        array_push($this->items, $input);
    }

    public function getData() {
        $arr = array();
        foreach ($this->items as $item) {
            $arr[$item->getName()] = $item->getValue();
        }
        if ($this->isValid())
            return $arr;
        else
            return array();
    }

    public function get($key) {
        $data = $this->getData();
        if (array_key_exists($key, $data))
            return $data[$key];
        else
            return "";
    }

    public function getHtml() {
        $url = Request::getBase()."/".Request::getUrl()."?".$_SERVER['QUERY_STRING'];
        $html = "<form action='".$url."' enctype='multipart/form-data' method='post'><input type='hidden' name='$this->name' value='1' />";
        $html .= "<input type='hidden' name='sessionid' value='".session_id()."' />";
        foreach ($this->items as $item) {
            $t = $item->getHtml();
            if ($t != "") $html .= "<div class='formitem notbutton ".get_class($item)."'>".$t."</div>";
        }
        return $html."<div class='formitem SubmitButton'><input type='submit' value='$this->submit' class='submitbutton' /></div></form>";
    }

    public function isValid() {
        foreach ($this->items as $item) {
            if (!$item->meetsRequirements()) {
				Response::flash("You entered '".$item->getValue()."' for '".$item->getName().".' That is not a valid value.");
                return false;
            }
        }
        return true;
    }

    public function getName() {
        return $this->name;
    }

    public function sent() {
        if (!isset($_POST["sessionid"]) || session_id() != $_POST["sessionid"]) return false;
        return isset($_POST[$this->getName()]) && $this->isValid();
    }

    public function controls($model) {
        if ($model instanceof SettingsCategory) {
            foreach ($this->items as $item) {
				$value = Settings::get($model->getName().".".$item->getName());
				if ($value != "") $item->setValue($value);
            }
        } else if ($model instanceof Model && $model->exists()) {
            foreach ($this->items as $item) {
                $item->setValue($model->get($item->getName()));
            }
        }

        if ($this->sent()) {
			if ($model instanceof Model && !$model->exists()) {
                Model::create(get_class($model), $this->getData());
            } else if ($model instanceof Model) {
                $model->set($this->getData());
            } else if ($model instanceof SettingsCategory) {
                Settings::save($model->getName(), $this->getData());
            } else if (is_string($model)) {
				Model::create($model, $this->getData());
			}
        }
    }
}