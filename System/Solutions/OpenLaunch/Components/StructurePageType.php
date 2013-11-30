<script type="text/javascript">
	function createPage(type) {
		var name = prompt("What would you like to name this page?");
		if (name) {
			window.location = "/admin/index/structure/index/create/"+type+"/?name="+name;
		}
	};
</script>
<div class="admin-entries">
	<div class="admin-entries-top">
		<div class="admin-entries-top-inner">
			<div class='admin-entries-button'><a href="/admin/index/structure/">Back</a></div>
			<h2>Page Center : Select Page Type</h2>
		</div>
	</div>
	<div class="admin-select-page-type">
		<?php foreach (PageType::getTypes() as $type) { ?>
		<div class="admin-entry">
			<div class="admin-entry-inner">
				<div class="admin-entry-inner-button">
					<a href="#" onclick="createPage('<?php echo $type->getId() ?>')">Create a Page</a>
				</div>
				<img src="<?php echo $type->getIcon() ?>" />
				<h2><?php echo $type->getName() ?></h2>
				<?php echo $type->getDescription() ?>
			</div>
		</div>
		<?php } ?>
	</div>
</div>