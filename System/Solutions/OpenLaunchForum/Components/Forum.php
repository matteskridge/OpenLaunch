<div class="forum">
	<?php echo Component::get("OpenLaunchForum.ForumHeader", array("forum" => $forum, "page" => $page)) ?>
	<div class="forum-topics">
		<div class="forum-topics-button">
			<?php if ($forum->canPost()) { ?>
			<a href="<?php echo $page->getLink("create/".$forum->getId()) ?>">Start a Discussion</a>
			<?php } ?>
		</div>
		<h2>Discussion</h2>
		<div class="forum-topics-inner">
			<?php foreach ($topics as $topic) { ?>
                <?php echo Component::get("OpenLaunchForum.TopicItem", array("page"=>$page,"topic"=>$topic)) ?>
			<?php } ?>
			<?php if (count($topics) == 0) { ?>
			<div class="forum-topics-empty-notice">
				This forum is empty
			</div>
			<?php } ?>
		</div>
	</div>
</div>