<?php

class Penalty extends Model {
	public function getStructure() {
		return array(
			"user" => "Person",
			"expires" => "integer",
			"warning" => "boolean",
			"suspension" => "boolean",
			"read" => "boolean",
			"revoked" => "boolean",
			"reason" => "string+"
		);
	}

	public function getLength() {
		$when = $this->getCreatedTime();
		$expires = $this->get("expires");

		return round(($expires-$when)/86400);
	}

	public function getType() {
		if ($this->get("warning")) {
			return "Warning";
		} else if ($this->get("suspension")) {
			return "Suspension";
		}
	}

	public function getColor() {
		if ($this->get("revoked")) {
			return "gray";
		} else if ($this->get("suspension")) {
			return "red";
		} else if ($this->get("warning")) {
			return "yellow";
		} else {
			return "white";
		}
	}
}