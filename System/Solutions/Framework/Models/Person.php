<?php

class Person extends Model {

	public function getStructure() {
		return array(
			"prefix" => "string",
			"first" => "string",
			"middle" => "string",
			"last" => "string",
			"suffix" => "string",
			"nickname" => "string",
			"email" => "string",
			"phone" => "string",
			"street" => "string",
			"suite" => "string",
			"city" => "string",
			"province" => "string",
			"zip" => "string",
			"country" => "string",
			"website" => "string",
			"organization" => "string",
			"facebook" => "string",
			"twitter" => "string",
			"openid" => "string",
			"profile" => "string+",
			"roles" => "list",
			"ipaddress" => "string",
			"ban" => "boolean",
			"confirmed" => "boolean",
			"confirmkey" => "string",
			"signature" => "string"
		);
	}

	public function onCreate($data) {
		if ($data["nickname"] == "") {
			$nickname = mt_rand(0, 99999999);
		}
		else
			$nickname = $data["nickname"];

		$other = new Person(array("nickname" => $data["nickname"], "id != '$this->id'"));
		$nickname = "";

		while ($other->exists()) {
			$nickname = $data["nickname"] . " " . mt_rand(0, 99999999);
			$other = new Person(array("nickname" => $nickname, "`id`!='$this->id'"));
		}

		if ($nicknane != $data["nickname"]) {
			$this->set("nickname", $nickname);
		}
	}

	public function checkPassword($password) {
		$hash = new File("System/Data/Credentials/person-" . $this->get("id") . ".php");
		if (!$hash->exists())
			return false;
		return Security::checkHash($password, $hash->read());
	}

	public function setPassword($password) {
		$hash = new File("System/Data/Credentials/person-" . $this->get("id") . ".php");
		$hash->write(Security::hash($password));
	}

	public function hasPassword() {
		$hash = new File("System/Data/Credentials/person-" . $this->get("id") . ".php");
		return $hash->exists();
	}

	public function getPasswordFile() {
		return new File("System/Data/Credentials/person-" . $this->get("id") . ".php");
	}

	public function getRoles() {
		$roles = array();
		foreach (Role::findAll("Role", array("allmembers" => true)) as $role)
			array_push($roles, $role);
		if (is_array($this->get("roles")))
			foreach ($this->get("roles") as $role)
				array_push($roles, new Role($role));
		return $roles;
	}

	public function getAvatarLink() {
		foreach (Attachments::getInfo("person-photo-" . $this->get("id")) as $info) {
			return $info["url"];
		}
		return get_gravatar($this->get("email"), 128, "identicon");
	}

	public function getAvatar($size = 128) {
		return "<img src='" . $this->getAvatarLink() . "' width='$size' height='$size' style='width:" . $size . "px;height:" . $size . "px;' />";
	}

	public function getName() {
		if ($this->get("nickname") == "")
			return "Un-Named";
		return "<a href='profile/".$this->getId()."'>".$this->get("nickname")."</a>";
	}

	public function getRealName() {
		$bits = array();
		if ($this->get("prefix") != "")
			array_push($bits, $this->get("prefix"));
		if ($this->get("first") != "")
			array_push($bits, $this->get("first"));
		if ($this->get("middle") != "")
			array_push($bits, ucfirst(substr($this->get("middle"), 0, 1)));
		if ($this->get("last") != "")
			array_push($bits, $this->get("last"));
		if ($this->get("suffix") != "")
			array_push($bits, $this->get("suffix"));
		$result = implode(" ", $bits);

		return (trim($result) == "") ? $this->getName() : $result;
	}

	public function getShortName() {
		$name = $this->getName();
		$max = 20;

		if (strlen($name) > $max) {
			$name = substr($name, 0, $max - 3) . "...";
		}
		return $name;
	}

	public function getTitle() {
		$role = $this->getPrimaryRole();
		return $role->get("name");
	}

	public function getPrimaryRole() {
		$roles = $this->getRoles();
		$top = 99;
		foreach ($roles as $r) {
			if ($r->get("importance") < $top) {
				$role = $r;
				$top = $r->get("importance");
			}
		}
		return $role;
	}

	public function getStreet() {
		return ($this->get("street") == "") ? "Unknown" : $this->get("street");
	}

	public function getCity() {
		return ($this->get("city") == "") ? "Unknown" : $this->get("city") . ", " . $this->get("province");
	}

	public function getAddress() {
		if ($this->get("street") == "")
			return "Unknown Address";
		return $this->get("street") . "\n" . $this->get("suite") . "\n" .
				$this->get("city") . ", " . $this->get("province") . ". " . $this->get("zip") . "\n" .
				$this->get("country");
	}

	public function getPhone() {
		if ($this->get("phone") == "") {
			return "Unknown";
		} else {
			$n = str_split($this->get("phone"));
			if (count($n) == 10) {
				return "(" . $n[0] . $n[1] . $n[2] . ") " . $n[3] . $n[4] . $n[5] . "-" . $n[6] . $n[7] . $n[8] . $n[9];
			} else if (count($n) == 11) {
				return "(" . $n[1] . $n[2] . $n[3] . ") " . $n[4] . $n[5] . $n[6] . "-" . $n[7] . $n[8] . $n[9] . $n[10];
			}
		}
		return $this->get("phone");
	}

	public function hasRole($role) {
		foreach ($this->get("roles") as $r) {
			if ($r == $role->get("id"))
				return true;
		}
		return false;
	}

	public function searchColumns() {
		return array("nickname", "email", "phone", "city", "street");
	}

	public function getOpenId() {
		$openid = new LightOpenID(Request::getDomain());
		$openid->identity = $this->get("openid");
		return $openid;
	}

	public function getOpenIdLink() {
		$openid = $this->getOpenId();
		return $openid->authUrl();
	}

	public function getRealm() {
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		return $protocol . $_SERVER['HTTP_HOST'] . "/openid/" . $this->getId() . "/";
	}

	public function sendEmail($text) {
		$domain = (Settings::get("email.domain") != "") ? Settings::get("email.domain") : Request::getDomain();
		$mail = new PHPMailer();

		if (Settings::get("email.host") != "") {
			$mail->IsSMTP();
			$mail->Host = Settings::get("email.host");  // Specify main and backup server
			$mail->SMTPAuth = true; // Enable SMTP authentication
			$mail->Username = Settings::get("email.user"); // SMTP username
			$mail->Password = Settings::get("email.password");   // SMTP password
			$mail->SMTPSecure = 'tls';
		} else {
			$mail->IsMail();
		}

		$mail->From = "confirmation@" . $domain;
		$mail->FromName = Website::getName();
		$mail->AddAddress($this->get("email"), $this->get("nickname"));
		$mail->AddReplyTo("support@$domain", Website::getName());

		$mail->WordWrap = 50;
		$mail->IsHTML(true);

		$mail->Subject = 'Please Confirm your Email';
		$mail->Body = $text;
		$mail->AltBody = strip_tags($text);

		return $mail->Send();
	}

	public function confirmEmail() {

		$result = $this->sendEmail(Component::get("CreationShare.ConfirmEmail", array(
					"key" => $key,
					"person" => $this
		)));

		if (!$result) {
			$this->set("confirm", "1");
			return false;
		} else {
			$this->set("confirm", "0");
			$this->set("confirmkey", $key = Random::getText(100));
		}
		return true;
	}

	public function getPageviews() {
		return PageView::count("PageView", array("person" => $this));
	}

	public function getDevices() {
		return PageView::count("PageView", array("person" => $this), "ipaddress");
	}

	public function getComments() {
		return Comment::count("Comment", array("person" => $this));
	}

	public function getBrowser() {
		return $this->getStatisticCommon("browser");
	}

	public function getPlatform() {
		return $this->getStatisticCommon("platform");
	}

	public function getForm() {
		return $this->getStatisticCommon("form");
	}

	private function getStatisticCommon($column) {
		$q = "SELECT `$column`, COUNT(*) AS magnitude FROM `PageView` WHERE `person`='" . $this->get("id") . "' GROUP BY `$column` ORDER BY magnitude DESC LIMIT 1";
		$q = mysql_query($q);

		while ($row = mysql_fetch_assoc($q)) {
			return $row[$column];
		}
		return "Unknown";
	}

	public function isGoogle() {
		return strstr($this->get("openid"), "google.com");
	}

	public function isYahoo() {
		return strstr($this->get("openid"), "yahoo.com");
	}

	public function isAOL() {
		return strstr($this->get("openid"), "aol.com");
	}

	public function isPassword() {
		return $this->get("openid") == "";
	}

	public function getIdentifier() {
		$id = $this->get("nickname");
		$id = str_replace(" ", ".", $id);
		$id = strtolower($id);
		return $id;
	}

	public function getProfile() {
		if ($this->get("profile") == "") {
			return "This person has not defined a profile";
		} else {
			return Parser::parse($this->get("profile"));
		}
	}

	public function addRole($role) {
		$roles = $this->get("roles");
		if (!in_array($role->getId(), $roles))
			array_push($roles, $role->getId());
		$this->set("roles", $roles);
	}

	public function removeRole($role) {
		$arr = array();
		foreach ($this->get("roles") as $r) {
			if ($role->getId() != $r) {
				array_push($arr, $r);
			}
		}
		$this->set("roles", $arr);
	}

	public function getProfileLink() {
		return "/profile/".$this->getId()."/";
	}

	public function getPrecedence() {
		$role = $this->getPrimaryRole();
		return $role->get("importance");
	}

	public function canControl($person) {
		return $this->getPrecedence() < $person->getPrecedence() || Permission::can();
	}

	public function canAssign($role) {
		$precedence = $this->getPrecedence();
		if ($precedence > $role->get("importance") && !Permission::can()) {
			return false;
		}
		return true;
	}
}

class FakePerson extends Person {

	private $data = array(
		"id" => "0",
		"name" => "Anonymous"
	);

	public function __construct() {

	}

	public function get($key) {
		if (!array_key_exists($key, $this->data)) {
			return "";
		}
		else
			return $this->data[$key];
	}

}

function get_gravatar($email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array()) {
	$url = 'http://www.gravatar.com/avatar/';
	$url .= md5(strtolower(trim($email)));
	$url .= "?s=$s&d=$d&r=$r";
	if ($img) {
		$url = '<img src="' . $url . '"';
		foreach ($atts as $key => $val)
			$url .= ' ' . $key . '="' . $val . '"';
		$url .= ' />';
	}
	return $url;
}

