<?php
$type = (array_key_exists("type", $banner))?$banner["type"]:"";

switch ($type) {
	case "text":
		$title = $banner["text"]["title"];
		$text = $banner["text"]["text"];
		echo "<h2>$title</h2>".Parser::parse($text);
		break;
	case "icon":
		$title = $banner["icon"]["title"];
		$text = $banner["icon"]["text"];
		$icon = $banner["icon"]["icon"];
		echo "<img src='$icon' /><h2>$title</h2>".Parser::parse($text);
		break;
	case "image":
		$image = $banner["image"]["image"];
		echo "<img src='$image' />";
		break;
	default:

		break;
}
?>