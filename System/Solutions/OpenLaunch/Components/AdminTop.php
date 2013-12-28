<?php if (Session::showAdminBar()) { ?>
	<div class="admin-search">

	</div>
	<table class="admin-table">
		<tr>
			<td class="admin-sidebar">
				<div class="admin-sidebar-wrap">
					<div class="admin-sidebar-logo">
						<a href=""><img src="Images/Logos/OpenLaunch/IconPlainWhite.png" /></a>
					</div>
					<div class="admin-sidebar-item">
						<a href="">Website</a>
					</div>
					<?php foreach (ControlItem::listItems() as $item) { ?>
						<div class="admin-sidebar-item<?php if ($item->isSelected()) echo " selected"; ?>">
							<a href="<?php echo $item->getLink() ?>"><?php echo $item->getName() ?></a>
						</div>
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
					<div class="admin-sidebar-item">
						<a href="javascript:search()">Search</a>
					</div>
				</div>
			</td>
			<td class="admin-middle">
<?php } ?>