<?php

class Application {

	private $file;
	private $info;

	public function __construct($file) {
		$this->file = $file;
		$this->info = Spyc::YAMLLoadString($file->getSub("application.yml")->read());
	}

    public function getFile() {
        return $this->file;
    }

	public function getName() {
		return $this->info["application"]["product"]["name"];
	}

	public function getAuthor() {
		return $this->info["application"]["author"]["name"];
	}

	public function isCore() {
		return array_key_exists("core", $this->info["application"]["product"]) &&
			$this->info["application"]["product"]["core"];
	}

	public function getAuthorWebsite() {
		return $this->info["application"]["author"]["website"];
	}

}

