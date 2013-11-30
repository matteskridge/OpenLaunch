<div class="admin-entries">
	<?php foreach (FeatureGalleryCategory::findAll("FeatureGalleryCategory", array("page" => $page), "`order`,`id`") as $category) { ?>
		<div class="admin-entries-header">
			<div class="admin-entries-header-inner">
				<div class='admin-entries-header-button'>
					<a href="/admin/index/structure/page/<?php echo $page->getId() ?>/?category=<?php echo $category->getId() ?>">Edit</a> -
					<a href="/admin/index/structure/page/<?php echo $page->getId() ?>/?category=<?php echo $category->getId() ?>&item">Add Item</a>
				</div>
				<h2><?php echo $category->get("name") ?></h2>
			</div>
		</div>
		<?php foreach (FeatureGalleryEntry::findAll("FeatureGalleryEntry", array("category" => $category)) as $item) { ?>
			<div class="admin-entry">
				<div class="admin-entry-inner">
					<div class="admin-entry-options">
						<a href="?item=<?php echo $item->getId() ?>">Edit</a>
					</div>
					<?php echo $item->get("name") ?>
				</div>
			</div>
		<?php } ?>
	<?php } ?>
	<div class="admin-entries-header">
		<div class="admin-entries-header-inner">
			<h2>Settings</h2>
		</div>
	</div>
	<div class="admin-entry">
		<div class="admin-entry-inner">
			<a href="/admin/index/structure/page/<?php echo $page->getId() ?>?category">Create a New Category</a>
		</div>
	</div>
</div>