
<?php if (Session::showAdminBar()) { ?>
<div class="admin-search">

</div>
<div class="adminbar">
	<div class="adminbar-inner">
		<div class="adminbar-search">
			<input type="text" name="search" value="Search Everything..." onclick="$(this).val('')" />
			<img src="Images/Black/IconFinder/SearchWhite.png" />
		</div>
		<div class="adminbar-menu">
			<div class="adminbar-menu-items">
				<div class="adminbar-menu-item">
					<a href=""><img src="Images/Logos/OpenLaunch/IconPlainWhite.png" /></a>
				</div>
				<div class="adminbar-menu-item<?php if (Response::getController() != "admin") echo " selected"; ?>">
					<a href="<?php echo Request::getBase() ?>">Website</a>
				</div>
				<?php foreach (ControlItem::listItems() as $item) { ?>
					<div class="adminbar-menu-item<?php if ($item->isSelected()) echo " selected"; ?>">
						<a href="<?php echo $item->getLink() ?>"><?php echo $item->getName() ?></a>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<?php /*if (Response::getController() == "admin") { ?>
<table class="admin-table">
	<tr>
		<td class="admin-sidebar">
			<div class="admin-sidebar-wrap">
				<?php foreach (ControlItem::listItems() as $item) { ?>
					<?php if ($item->isSelected()) { ?>
						<div class="admin-sidebar-subs">
							<?php foreach ($item->getMenu() as $k => $m) { ?>
								<div class="admin-sidebar-item">
									<a href="<?php echo $item->getLink() ?><?php echo $k ?>/"><?php echo $m ?></a>
								</div>
							<?php } ?>
						</div>
					<?php } ?>
				<?php } ?>
			</div>
		</td>
		<td class="admin-middle">
<?php }*/ ?>

<?php } ?>