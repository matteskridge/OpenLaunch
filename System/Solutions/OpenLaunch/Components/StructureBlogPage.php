
<div class='page-manager'>
	<div class='page-manager-inner'>
		<div class='page-manager-button'>
			<?php if (isset($_GET["create"]) || isset($_GET["edit"])) { ?>
			<a href='/admin/index/structure/page/<?php echo $page->get("id") ?>/'>Back</a>
			<?php } else { ?>
			<a href='/admin/index/structure/page/<?php echo $page->get("id") ?>/?create'>Create Category</a>
			<?php } ?>
			
		</div>
		<h1>Blog Categories</h1>
		<?php if (isset($form) && $form != "") { ?>
		<div class='page-manager-form'>
			<?php echo $form ?>
		</div>
		<?php } else { ?>
		
		<?php foreach ($categories as $cat) { ?>
		<div class='page-manager-category'>
			<span style="float:right">
				<a href="/admin/index/structure/page/<?php echo $page->get("id") ?>/?edit=<?php echo $cat->get("id") ?>">Edit</a> - 
				<a href="/admin/index/structure/page/<?php echo $page->get("id") ?>/?delete=<?php echo $cat->get("id") ?>" onclick="return confirm('Really delete this category?')">Delete</a>
			</span>
			<?php echo $cat->get("name") ?>
		</div>
		<?php } if (count($categories) == 0) { ?>
		<div class='page-manager-category page-manager-category-notice'>
			You haven't defined any categories. <a href='/admin/index/structure/page/<?php echo $page->get("id") ?>/?create'>Create a Category</a>
		</div>
		<?php } ?>
		
		<?php } ?>
	</div>
</div>
