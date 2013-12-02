<?php if (isset($form)) { ?>
	<div class="settings-roles">
		<?php echo $form ?>
	</div>
<?php } else { ?>
	<div class="settings-roles">
		<?php foreach ($roles as $role) { ?>
			<div class="settings-role">
				<div class="settings-role-inner">
                    <?php if (($role->get("importance") > Session::getPerson()->getPrecedence()) || Permission::can()) { ?>
					<div class="settings-role-right">
						<a href="admin/index/settings/roles/<?php echo $role->getId() ?>/">Edit</a>
					</div>
                    <?php } ?>
					<?php echo $role->get("name") ?>
				</div>
			</div>
		<?php } ?>
		<div class="settings-role">
			<div class="settings-role-inner" style="text-align:center;">
				<a href="admin/index/settings/roles/0/">Create a new Role</a>
			</div>
		</div>
	</div>
<?php } ?>