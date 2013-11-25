<?php

class RolesSettingsItem extends SettingsItem {

	public function getName() {
		return "Roles";
	}

	public function getOrder() {
		return 300;
	}

	public function getContent() {
		$roles = Role::findAll("Role");
		$data = array("roles" => $roles);

		if (is_numeric(Response::getArg(2))) {
			if (Response::getArg(2) != "") {
				$role = new Role(Response::getArg(2));
			}

			$permissions = (isset($role)) ? $role->get("permissions") : array();

			$form = new Form("settings-role");
			$form->add(new TextField("name", "Role Name"));
			$form->add(new PermissionField("permissions", "Permissions", $permissions));
			$form->add(new CheckboxField("allmembers", "Assign to Everyone"));
			$form->add(new CheckboxField("allguests", "Assign to Guests"));
			$form->controls((isset($role)) ? $role : "Role");
			$data["form"] = $form->getHtml();

			if ($form->sent())
				return new Redirect("/admin/index/settings/roles/");
		}

		return Component::get("OpenLaunch.SettingsRoles", $data);
	}

	public function can() {
		return Permission::can("SettingsRoles");
	}

}

