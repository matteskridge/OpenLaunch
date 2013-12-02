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

}

