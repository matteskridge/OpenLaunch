<div class='admin-structure-settings'>
	<div class="admin-entries-top">
		<div class="admin-entries-top-inner">
			<h2>Settings Center</h2>
		</div>
	</div>
	<div class='admin-entries-menu'>
		<div class='admin-entries-menu-inner'>
			<div class='admin-entries-menu-item'><a href='/admin/index/settings/'>Dashboard</a></div>
			<?php foreach (SettingsItem::listAll() as $item) { ?>
			<div class='admin-entries-menu-item'><a href='/admin/index/settings/<?php echo $item->getId() ?>/'><?php echo $item->getName() ?></a></div>
			<?php } ?>
		</div>
	</div>
	<div class='admin-structure-settings-main'>
		<?php echo $content ?>
	</div>
</div>