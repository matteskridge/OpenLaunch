<?php

/* =================================
 * CreationShare Platform
 *
 * (c) CreationShare Technology LLC
 * =================================
 */

class UploadField extends InputField {
    public function getHtml() {
		$text .= "<div class='attachments-top'>";
        $text .= "<label for='$this->id'>$this->display</label>";
        $text .= "<div style='display:inline-block;vertical-align:center;'>";
        $text .= "<input type='file' name='$this->id' id='$this->id' />";
        $text .= "</div>";
		$text .= "</div>";
		$text .= Attachments::get($this->id, true);
        return $text;
    }

    public function getValue() {
        if (file_exists($_FILES[$this->id]["tmp_name"])) {
            $time = time();

            $dir = new File("System/Data/Uploads/".$this->id."/$time");
			if (in_array("onefile", $this->valid)) foreach ($dir->getParent()->listSubs() as $f) $f->delete();
            $dir->makeDirectories();

			$temp = new File($_FILES[$this->id]["tmp_name"]);
			if (in_array("image", $this->valid) && !$temp->isImage()) return "";

			move_uploaded_file($_FILES[$this->id]["tmp_name"],
                "System/Data/Uploads/".$this->id."/$time/upload.txt");

            $file = new File("System/Data/Uploads/".$this->id."/$time/readkey.txt");
            $file->write(Random::getText(50));

            $file = new File("System/Data/Uploads/".$this->id."/$time/writekey.txt");
            $file->write(Random::getText(50));

            $file = new File("System/Data/Uploads/".$this->id."/$time/owner.txt");
            $file->write(Session::getPerson()->get("id"));

            $file = new File("System/Data/Uploads/".$this->id."/$time/filename.txt");
            $file->write($_FILES[$this->id]["name"]);
        }

        return "";
    }
}

class Attachments {
    static function attachmentBit($file, $canEdit = false) {
		if (count($file->listSubs()) > 0) $text = "<div class='attachments'>";

        foreach ($file->listSubs() as $key => $value) {
            $upload = $value->getSub("upload.txt");
            $fname = $value->getSub("filename.txt")->read();
            $writekey = $value->getSub("writekey.txt")->read();
            $readkey = $value->getSub("readkey.txt")->read();
            $url = $file->getName()."/".$value->getName();

            if ($canEdit) {
                $drop = "<span style='float:right;margin-left:10px;'>";
                $drop .= "<a href='file/delete/$url/?key=$writekey'>x</a>";
                $drop .= "</span>";
            } else {
                $drop = "";
            }

            $text .= "<div class='attachment-entry'>$drop";
            $text .= "<a href='file/view/$url/?key=$readkey'>$fname</a>";
            $text .= "</div>";
        }

		if (count($file->listSubs()) > 0) $text .= "</div>";

        return $text;
    }

    static function get($id, $manage = false) {
        $file = new File("System/Data/Uploads/$id/");
        return self::attachmentBit($file, $manage);
    }

    static function getFiles($id) {
        $file = new File("System/Data/Uploads/$id/");
        return $file->listSubs();
    }

	static function getInfo($id) {
        $file = new File("System/Data/Uploads/$id/");

		$arr = array();
        foreach ($file->listSubs() as $value) {
            $fname = $value->getSub("filename.txt")->read();
            $writekey = $value->getSub("writekey.txt")->read();
            $readkey = $value->getSub("readkey.txt")->read();
            $url = $file->getName()."/".$value->getName();
			array_push($arr, array(
				"name" => $fname,
				"writekey" => $writekey,
				"readkey" => $readkey,
				"url" => "/file/view/$url/?key=$readkey&now=".time(),
				"file" => $value,
				"time" => $value->getName(),
				"id" => $value->getParent()->getName()
			));
		}

		return $arr;
	}
}