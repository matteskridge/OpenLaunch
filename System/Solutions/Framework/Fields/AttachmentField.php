<?php

class AttachmentField extends InputField {
	public function getHtml() {
		return "<label for='$this->id'>$this->display</label> <input type='file' name='$this->id' id='$this->id' />";
	}

	public function getValue() {
		$path = "";

		if (file_exists($_FILES[$this->id]['tmp_name']) && $_FILES[$this->id]["error"] == 0) {
			$dir = new File("System/Data/Uploads/$this->id-".time()."/");
			$dir->makeDirectories();

			$tmp = new File($_FILES[$this->id]["tmp_name"]);

			$file = $dir->getSub("data.txt");
			$file->write($tmp->read());

			$name = $dir->getSub("name.txt");
			$name->write($_FILES[$this->id]["name"]);

			$type = $dir->getSub("type.txt");
			$type->write($_FILES[$this->id]["type"]);

			$pubkey = $dir->getSub("public.txt");
			$pubkey->write(Random::getText(256));

			$privkey = $dir->getSub("private.txt");
			$privkey->write(Random::getText(256));
			return $dir->getPath();
		} else {
			return $this->value;
		}

		return $path;
	}
}

class Attachment {
	private $file;

	public function __construct($name) {
		$this->file = new File($name);
	}

	public function __toString() {
		return $this->file->getPath();
	}

	public function getLink($w = 0, $h = 0) {
		return "/file/attachment/".$this->file->getName()."/$w/$h?public=".$this->getPublicKey();
	}

	public function getPublicKey() {
		return $this->file->getSub("public.txt")->read();
	}

	public function getPrivateKey() {
		return $this->file->getSub("private.txt")->read();
	}
}