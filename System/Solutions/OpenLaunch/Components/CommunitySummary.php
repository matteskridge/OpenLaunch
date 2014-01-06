<div class="admin-entries">
	<div class="admin-entries-top">
		<div class="admin-entries-top-inner">
			<h2>Community Center</h2>
		</div>
	</div>
	<?php echo Component::get("OpenLaunch.CommunityMenu") ?>
	<div class="admin-entry">
		<div class="admin-entry-inner">
			<?php echo Statistics::getWeekGraph() ?>
		</div>
	</div>
	<div class="admin-entry">
		<form action="admin/index/community/people" method="post">
			<div class="admin-entry-inner">
				<div class="admin-entry-search">
					<div class="admin-entry-search-box"><input type="text" name="query" value="" /></div><div class="admin-entry-search-button"><input type="submit" value="Search People" /></div>
				</div>
			</div>
		</form>
	</div>
	<div class="admin-entry">
		<div class="admin-entry-inner">
			<h2>Recent Comments</h2>
		</div>
	</div>
</div>