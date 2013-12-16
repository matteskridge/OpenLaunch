
<div class="blog-center">
	<div class="blog-center-posts">
		<?php foreach (BlogPost::findAll("BlogPost", array(), "`id` DESC") as $item) { ?>
		<div class="blog-center-post">
			<div class="blog-center-post-inner">
				<div class="blog-center-post-options">
					<a href="admin/index/structure/posts/<?php echo $item->getId() ?>/">Edit Post</a>
					- <a href="admin/index/structure/posts/<?php echo $item->getId() ?>/delete/?sid=<?php echo session_id() ?>" onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
				</div>
				<h2><?php echo $item->get("name") ?></h2>
				<?php echo Parser::parse($item->get("content")) ?>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
