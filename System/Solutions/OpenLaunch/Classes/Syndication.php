<?php

class Syndication {

	public static $news = "http://openlaunch.org/page/8/1/feed.rss";

	public static function getRSS($url) {
        $data = file_get_contents($url);
		try {
            $xml = new SimpleXMLElement($data);

            $array = array();
            foreach ($xml->channel->item as $item) {
                array_push($array, array(
                    "name" => $item->title,
                    "content" => $item->description,
                    "link" => $item->link
                ));
            }
        } catch (Exception $e) {
            return "Could not read RSS feed ".$url.": ".$e->getMessage()."<br />";
        }
		return $array;
	}

	public static function getLatest($url) {
		$arr = self::getRSS($url);
        if (is_array($arr)) {
            return $arr[0];
        } else {
            return $arr;
        }
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

