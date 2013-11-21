<?php

function recurse_copy($src, $dst) {
	$dir = opendir($src);
	@mkdir($dst);
	while (false !== ( $file = readdir($dir))) {
		if (( $file != '.' ) && ( $file != '..' ) && ($file != "nbproject") && ($file != "README.md") && ($file != "LICENSE")) {
			if (is_dir($src . '/' . $file)) {
				recurse_copy($src . '/' . $file, $dst . '/' . $file);
			} else {
				copy($src . '/' . $file, $dst . '/' . $file);
			}
		}
	}
	closedir($dir);
}

function rrmdir($dir) {
	if (is_dir($dir)) {
		$objects = scandir($dir);
		foreach ($objects as $object) {
			if ($object != "." && $object != "..") {
				if (filetype($dir . "/" . $object) == "dir")
					rrmdir($dir . "/" . $object);
				else
					unlink($dir . "/" . $object);
			}
		}
		reset($objects);
		rmdir($dir);
	}
}

$fh = fopen("master.zip", "w");
fwrite($fh, file_get_contents("http://github.com/Eskridge/OpenLaunch/archive/master.zip"));
fclose($fh);

$zip = new ZipArchive();
$zip->open("master.zip");
$zip->extractTo(".");
$zip->close();

recurse_copy("OpenLaunch-master", ".");

unlink("master.zip");
rrmdir("OpenLaunch-master");
header("Location: index.php");