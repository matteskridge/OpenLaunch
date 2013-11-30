
<div class='page-manager'>
	<div class='page-manager-inner'>
		<div class="admin-entries-header">
			<div class="admin-entries-header-inner">
				<div class='admin-entries-header-button'>
					<?php if (isset($_GET["create"]) || isset($_GET["edit"])) { ?>
						<a href='/admin/index/structure/page/<?php echo $page->get("id") ?>/'>Back</a>
					<?php } else { ?>
						<a href='/admin/index/structure/page/<?php echo $page->get("id") ?>/?create'>Create Category</a>
					<?php } ?>
				</div>
				<h2>Blog Categories</h2>
			</div>
		</div>
		<?php if (isset($form) && $form != "") { ?>
			<div class='admin-entry'>
				<div class="admin-entry-inner">
					<?php echo $form ?>
				</div>
			</div>
		<?php } else { ?>

			<?php foreach ($categories as $cat) { ?>
				<div class='admin-entry'>
					<div class="admin-entry-inner">
						<span style="float:right">
							<a href="/admin/index/structure/page/<?php echo $page->get("id") ?>/?edit=<?php echo $cat->get("id") ?>">Edit</a> -
							<a href="/admin/index/structure/page/<?php echo $page->get("id") ?>/?delete=<?php echo $cat->get("id") ?>" onclick="return confirm('Really delete this category?')">Delete</a>
						</span>
						<?php echo $cat->get("name") ?>
					</div>
				</div>
			<?php } if (count($categories) == 0) { ?>
				<div class='admin-entry'>
					<div class="admin-entry-inner">
						You haven't defined any categories. <a href='/admin/index/structure/page/<?php echo $page->get("id") ?>/?create'>Create a Category</a>
					</div>
				</div>
			<?php } ?>

		<?php } ?>
	</div>
</div>
