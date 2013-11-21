<?php

class ApiController extends AppController {

	public function news() {
		return Syndication::getNewsHtml();
	}

}

