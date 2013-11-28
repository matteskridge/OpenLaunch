<?php

class ImportanceField extends SelectField {
	public function init() {
		if ($this->value == "") $this->Value = "21";
		$this->options = array(
			"#01 - Company Owner",
			"#02 - Board of Directors",
			"#03 - Chief Executive Officer",
			"#04 - Executive Officer (Senior)",
			"#05 - Executive Officer (Junior)",
			"#06 - President",
			"#07 - Vice President (Senior)",
			"#08 - Vice President (Junior)",
			"#09 - Manager (Senior)",
			"#10 - Manager (Middle)",
			"#11 - Manager (Junior)",
			"#12 - Supervisor (Senior",
			"#13 - Supverisor (Junior)",
			"#14 - Employee (Senior)",
			"#15 - Employee (Middle)",
			"#16 - Employee (Junior)",
			"#17 - Employee (Intern)",
			"#18 - Volunteer (Senior",
			"#19 - Volunteer (Junior)",
			"#20 - User (Well-Resprected)",
			"#21 - User (Standard)",
			"#22 - User (Untrusted)"
		);
	}
}