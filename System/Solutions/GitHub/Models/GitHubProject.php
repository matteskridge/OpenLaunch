<?php

class GitHubProject extends Model {

	private $wait = 3600;

	public function getStructure() {
		return array(
			"name" => "string",
			"githubuser" => "string",
			"githubproject" => "string",
			"production" => "string",
			"url" => "string",
			"created" => "string",
			"pushed" => "string",
			"forks" => "integer",
			"branches" => "integer",
			"issues" => "integer",
			"watchers" => "integer",
			"language" => "string",
			"size" => "integer",
			"page" => "Page",
			"content" => "string+"
		);
	}

	public function maybeUpdate() {
		if ($this->get("cs_modified")+$this->wait<time() || $this->get("created") == "") {
			$this->update();
		}
	}

	public function onCreate($data) {
		$this->update();
	}

	public function update() {
		$user = $this->get("githubuser");
		$project = $this->get("githubproject");

		$url = curl_init();
		curl_setopt($url, CURLOPT_URL, "https://api.github.com/repos/$user/$project");
		curl_setopt($url, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($url, CURLOPT_USERAGENT, "OpenLaunch/".PRODUCT_BUILD." ".Request::getDomain());
		$text = curl_exec($url);

		$data = json_decode($text);


		$this->set(array(
			"name" => $data->name,
			"url" => $data->html_url,
			"created" => $data->created_at,
			"pushed" => $data->pushed_at,
			"size" => $data->size,
			"watchers" => $data->watchers_count,
			"language" => $data->language,
			"issues" => $data->open_issues_count
		));
	}
}