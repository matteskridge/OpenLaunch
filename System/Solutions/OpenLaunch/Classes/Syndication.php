<?php

class Syndication {

	public static $news = "http://openlaunch.org/page/8/1/feed.rss";

	public static function getRSS($url) {
		$xml = new SimpleXMLElement(file_get_contents($url));
		$array = array();
		foreach ($xml->channel->item as $item) {
			array_push($array, array(
				"name" => $item->title,
				"content" => $item->description,
				"link" => $item->link
			));
		}
		return $array;
	}

	public static function getLatest($url) {
		$arr = self::getRSS($url);
		return $arr[0];
	}

	public static function getNews() {
		return self::getRSS(self::$news);
	}

	public static function getLatestNews() {
		return self::getLatest(self::$news);
	}

	public static function getNewsHtml() {
		return Component::get("OpenLaunch.News");
	}

}

