<?php

class CensorParser extends Parser {
	public function getText($text) {
		return Censor::censorText($text);
	}
	public function getOrder() {
		return 1000;
	}
}

class Censor {
	public function censorText($text) {
		$badwords = new File("System/Data/badwords.yml");
		$yml = SPYC::YAMLLoad($badwords->read());
		
		$settings = array(
			"profanity" => Settings::get("censor.profanity"),
			"insult" => Settings::get("censor.insult"),
			"sex" => Settings::get("censor.sex")
		);
		
		$words = array();
		foreach ($yml["words"] as $key => $w) {
			if ($settings[$key] == 0) continue;
			foreach ($w as $word => $level) {
				if ($level >= $settings[$key]) continue;
				array_push($words, $word);
			}
		}
		
		if ($words == array()) return $text;
		
		$preg = "";
		$first = true;
		foreach ($words as $word) {
			if (!$first) $preg .= "|";
			$preg .= "$word";
			$first = false;
		}
		
		$rep = " ***** ";
		$punc = "\b";
		
		$text = preg_replace("@^($preg)($punc)@si", $rep, $text);
		$text = preg_replace("@($punc)($preg)($punc)@si", $rep, $text);
		$text = preg_replace("@($punc)($preg)$@si", $rep, $text);
		return $text;
	}
}