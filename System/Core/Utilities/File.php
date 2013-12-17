<?php

/* =================================
 * CreationShare Platform
 *
 * (c) CreationShare Technology LLC
 * =================================
 */

class File {
    private $path;

    function __construct($path) {
        if (substr($path, strlen($path)-1,1) == "/") {
            $path = substr($path, 0, strlen($path)-1);
        }
        $this->path = str_replace("//", "/", $path);
    }

    function isDirectory() {
        return is_dir($this->path);
    }

    /**
     *
     * @return array An array of File which represents the directory's sub directories.
     */
    function listSubs() {
        $arr = array();

        if ($handle = @opendir($this->path)) {
            while (false !== ($entry = readdir($handle))) {
                if (strlen($entry) < 1 || substr($entry,0,1) == ".") continue;

                array_push($arr, new File($this->path."/".$entry));
            }
        }

        return $arr;
    }

    public function getSub($name) {
        return new File($this->path."/".$name);
    }

    public function getParent() {
        $bits = explode("/", $this->path);
        array_pop($bits);
        return new File(implode("/", $bits));
    }

    public function getName() {
        $bits = explode("/", $this->path);
        return $bits[count($bits)-1];
    }

    public function getExtensionlessName() {
        $name = $this->getName();
        $bits = explode(".", $name);
        return $bits[0];
    }

    public function getExtension() {
        $name = $this->getName();
        $bits = explode(".", $name);
        return $bits[count($bits)-1];
    }

    public function includeFile() {
		if ($this->isDirectory()) {
			foreach ($this->listSubs() as $sub) {
				$sub->import();
			}
		} else if ($this->exists()) {
            require_once($this->path);
		}
    }

    public function import() {
        $this->includeFile();
    }

    public function getPath() {
        return $this->path;
    }

    public function __toString() {
        return $this->path;
    }

    public function exists() {
        return file_exists($this->getPath());
    }

    public function output($maxwidth = "", $maxheight = "") {
        $expires = 60*60*24*14;
        header("Pragma: public");
        header("Cache-Control: maxage=".$expires);
        header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
        header("Content-type: ".$this->getMimeType());

        if ($maxwidth != "" && $maxheight != "") {
            $image = new SimpleImage();
            $image->load($this->path);

			if ($maxwidth == "scale") {
				$image->scale($maxheight);
			} else {
				if ($maxwidth == 0) {
					$image->resizeToHeight($maxheight);
				} else if ($maxheight == 0) {
					$image->resizeToWidth($maxwidth);
				} else {
					$image->resize($maxwidth, $maxheight);
				}
			}

            $image->output();
            exit;
        }

        readfile($this->path);
    }

	public function isImage() {
		try {
			getimagesize($this->path);
			return true;
		} catch (Exception $e) {
			return false;
		}
	}

	public function getImage() {
		$img = new SimpleImage();
		$img->load($this->path);
		return $img;
	}

    public function getMimeType() {
        $ext = $this->getExtension();
        if ($ext == "png") {
            return "image/png";
        } else if ($ext == "gif") {
            return "image/gif";
        } else if ($ext == "jpg" || $ext == "jpeg") {
            return "image/jpeg";
        } else if ($ext == "js") {
            return "text/javascript";
        } else if ($ext == "css") {
            return "text/css";
        } else if ($ext == "ico") {
            return "image/png";
        }
    }

    function read() {
        if (!$this->exists()) return "";
        if (filesize($this->path) == 0) return "";
        $h = fopen($this->path, "r");
        $text = fread($h, filesize($this->path));
        fclose($h);
        return $text;
    }

    function write($text) {
        $h = fopen($this->path, "w");
        fwrite($h, $text);
        fclose($h);
    }

    function append($text) {
        $h = fopen($this->path, "a");
        fwrite($h, $text);
        fclose($h);
    }

    function writable() {
        return is_writable($this->path);
    }

    function readable() {
        return is_readable($this->path);
    }

    function makeDirectories() {
        @mkdir($this->path, 0777, true);
    }

    function getRelativePath($file) {
        $text = str_replace($file->getPath(), "", $this->path);
        if (substr($text, 0, 1) != "/") $text = "/$text";
        return $text;
    }

    function delete() {
        if ($this->isDirectory()) {
            foreach ($this->listSubs() as $key => $value) {
                $value->delete();
            }
            rmdir($this->getPath());
        } else unlink($this->getPath());
    }

    function loadYAML() {
        return spyc_load_file($this->getPath());
    }

    static function getTemp() {
        return new File("System/Temporary");
    }

    function clear() {
        foreach ($this->listSubs() as $key => $value) {
            $value->delete();
        }
    }

    public function encrypt() {
        $text = $this-read();
        $this->write(Crypt::encrypt($text, $key = Random::getText(strlen($text))));
        return $key;
    }

    public function decrypt($key) {
        return Crypt::decrypt($this->read(), $key);
    }

    public function getModified() {
        return date("F d Y", filemtime($this->path));
    }

    public function getModifiedTime() {
        return filemtime($this->path);
    }

    public function getType() {
        $type = filetype($this->path);
        if ($type == "dir") {
            return "Directory";
        } else {
            return $this->getExtension()." File";
        }
    }

    public function getPathRelativeTo($file) {
        $rootpath = $file->getPath();
        $thispath = $this->path;

        $p = substr($thispath, strlen($rootpath));
        if (substr($p,0,1) == "/") {
            return substr($p,1);
        } else {
            return $p;
        }
    }
}
