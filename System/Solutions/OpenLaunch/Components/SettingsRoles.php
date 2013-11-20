<div class="settings-roles">
	<?php foreach ($roles as $role) { ?>
	<div class="settings-role">
		<div class="settings-role-inner">
			<div class="settings-role-right">
				<a href="/admin/index/settings/roles/<?php echo $role->getId() ?>/">Edit</a>
			</div>
			<?php echo $role->get("name") ?>
		</div>
	</div>
	<?php } ?>
</div>