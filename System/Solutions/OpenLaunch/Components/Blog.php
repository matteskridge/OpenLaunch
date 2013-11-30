<?php if (count($categories) > 0) { ?>
	<div class="page-toolbar">
		<div class="page-toolbar-icons">
			<div><a href="<?php echo $feed ?>" target="_blank"><img src="Images/Logos/ThirdParty/RSS.png" /></a></div>
		</div>
		<div class="page-toolbar-item"><a href="<?php echo $page->getLink() ?>">All Categories</a></div>
		<?php foreach ($categories as $item) { ?>
			<div class="page-toolbar-item"><a href="<?php echo $page->getLink($item->getId() . "/") ?>"><?php echo $item->get("name") ?></a></div>
		<?php } ?>
	</div>
<?php } ?>

<div class="page-blogposts">
	<?php foreach ($posts as $post) { ?>
		<div class="page-blogpost">
			<div class="page-blogpost-date">
				<?php echo $post->getCreated() ?>
			</div>
			<h2><?php echo $post->get("name") ?></h2>
			<?php echo Parser::parse($post->get("content")) ?>
		</div>
	<?php } ?>
</div>
