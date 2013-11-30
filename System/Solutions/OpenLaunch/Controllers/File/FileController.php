<?php

class FileController extends AppController {
	public function attachment($id, $width = "", $height = "") {
		if (strstr($id, "/")) exit;
		$file = new File("System/Data/Uploads/$id");
		if ($file->getSub("public.txt")->read() == $_GET["public"]) {
			$file->getSub("data.txt")->output($width, $height);
			return;
		} else {
			echo "wrong key.";
			return new NotFoundError();
		}
	}
}