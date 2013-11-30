<div class="account-item">
	<div class="account-item-inner">
		<h2><?php echo $panel->getName() ?></h2>
		<img src="<?php echo $panel->getIcon() ?>" />
		<div class="account-menu">
			<?php foreach ($panel->getMenu() as $key => $item) { ?>
				<div class="account-menu-item">
					<a href="account/panel/<?php echo $panel->getId() ?>/<?php echo $key ?>/"><?php echo $item ?></a>
				</div>
			<?php } ?>
		</div>
	</div>
</div>