<?php
$find = array("page" => $page);
$categories = BlogCategory::findAll("BlogCategory", array("page" => $page));

if (Response::getArg(1) != "") {
	$find["category"] = new BlogCategory(Response::getArg(1));
}
?>

<?php if (count($categories) > 0) { ?>
<div class="page-toolbar">
	<div class="page-toolbar-item"><a href="<?php echo $page->getLink() ?>">All Categories</a></div>
	<?php foreach ($categories as $item) { ?>
	<div class="page-toolbar-item"><a href="<?php echo $page->getLink($item->getId()."/") ?>"><?php echo $item->get("name") ?></a></div>
	<?php } ?>
</div>
<?php } ?>

<div class="page-blogposts">
	<?php foreach (BlogPost::findAll("BlogPost", $find, "`id` DESC") as $post) { ?>
	<div class="page-blogpost">
		<div class="page-blogpost-date">
			<?php echo $post->getCreated() ?>
		</div>
		<h2><?php echo $post->get("name") ?></h2>
		<?php echo Parser::parse($post->get("content")) ?>
	</div>
	<?php } ?>
</div>
