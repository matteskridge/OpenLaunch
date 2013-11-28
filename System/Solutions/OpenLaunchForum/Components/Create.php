<div class="forum">
	<?php echo Component::get("OpenLaunchForum.ForumHeader", array("forum" => $forum, "page" => $page)) ?>
	<div class="forum-topics">
		<div class="forum-topics-button">
			<a href="<?php echo $page->getLink("forum/".$forum->getId()) ?>">Back to Forum</a>
		</div>
		<h2>Create a Topic</h2>
		<div class="forum-topics-inner">
			<div class="forum-topics-inner-create">
				<?php echo $form ?>
			</div>
		</div>
	</div>
</div>