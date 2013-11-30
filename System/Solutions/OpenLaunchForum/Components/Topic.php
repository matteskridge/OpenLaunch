<div class="forum">
	<div class="forum-header">
		<div class="forum-topic-options">
			<?php if (Permission::can("ForumClose")) { ?>
				<div class="forum-topic-option"><a href="<?php echo $page->getLink("moderate/".$topic->getId()."/close/".(($topic->get("closed"))?"0":"1")."/") ?>"><?php echo ($topic->get("closed"))?"Open":"Close" ?></a></div>
			<?php } ?>

			<?php if (Permission::can("ForumPin")) { ?>
				<div class="forum-topic-option"><a href="<?php echo $page->getLink("moderate/".$topic->getId()."/pin/".(($topic->get("pinned"))?"0":"1")."/") ?>"><?php echo ($topic->get("pinned"))?"Unstick":"Stick" ?></a></div>
			<?php } ?>

			<?php if (Permission::can("ForumHide")) { ?>
				<div class="forum-topic-option"><a href="<?php echo $page->getLink("moderate/".$topic->getId()."/hide/".(($topic->get("hidden"))?"0":"1")."/") ?>"><?php echo ($topic->get("hidden"))?"Unhide":"Hide" ?></a></div>
			<?php } ?>

			<?php if (Permission::can("ForumMove")) { ?>
				<div class="forum-topic-option"><a href="<?php echo $page->getLink("moderate/".$topic->getId()."/close/1/") ?>">Move</a></div>
			<?php } ?>
		</div>
		<h2><?php echo $forum->get("name") ?> : <?php echo $topic->get("name") ?> <a href="<?php echo $page->getLink("forum/".$forum->getId()."/") ?>">back</a></h2>
	</div>
	<div class="forum-topic">
		<?php echo Comment::getComments($topic, $topic->get("closed") && !Permission::can("ForumClose")) ?>
	</div>
</div>