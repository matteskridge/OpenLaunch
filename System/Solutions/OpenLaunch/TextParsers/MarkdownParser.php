<?php

class MarkdownParser extends Parser {
	public function getText($text) {
		return Markdown::parse($text);
	}
	public function getOrder() {
		return 100;
	}
}