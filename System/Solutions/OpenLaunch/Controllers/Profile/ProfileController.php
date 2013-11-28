<?php

class ProfileController extends AppController {
	public function view($id) {
		$person = new Person($id);
		if (!$person->exists())
			return new NotFoundError();
		$this->person = $person;
	}
}