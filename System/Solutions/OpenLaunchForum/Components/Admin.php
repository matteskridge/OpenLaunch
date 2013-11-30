<div class="admin-entries">
	<?php foreach (ForumCategory::findAll("ForumCategory", array("page" => $page), "`order`,`id`") as $category) { ?>
	<div class="admin-entries-header">
		<div class="admin-entries-header-inner">
			<div class='admin-entries-header-button'>
				<a href="/admin/index/structure/page/<?php echo $page->getId() ?>/?category=<?php echo $category->getId() ?>">Edit</a> -
				<a href="/admin/index/structure/page/<?php echo $page->getId() ?>/?category=<?php echo $category->getId() ?>&forum">Add Forum</a>
			</div>
			<h2><?php echo $category->get("name") ?></h2>
		</div>
	</div>
	<?php foreach (Forum::findAll("Forum", array("category" => $category)) as $forum) { ?>
	<div class="admin-entry">
		<div class="admin-entry-inner">
			<div class="admin-entry-options">
				<a href="?forum=<?php echo $forum->getId() ?>">Edit</a>
			</div>
			<?php echo $forum->get("name") ?>
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