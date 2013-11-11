
<div class="page-toolbar">
	<div class="page-toolbar-item"><a href="<?php echo $page->getLink("/") ?>">All Categories</a></div>
	<?php foreach (BlogCategory::findAll("BlogCategory", array("page" => $page)) as $item) { ?>
	<div class="page-toolbar-item"><a href="<?php echo $page->getLink("/") ?>"><?php echo $item->get("name") ?></a></div>
	<?php } ?>
</div>

<div class="page-blogposts">
	<?php foreach (BlogPost::findAll("BlogPost", array("page" => $page)) as $post) { ?>
	<div class="page-blogpost">
		<h2><?php echo $post->get("name") ?></h2>
		<?php echo Parser::parse($post->get("content")) ?>
	</div>
	<?php } ?>
</div>
