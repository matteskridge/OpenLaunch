<div class="forum">
	<!--<div class="forum-navigation">
        <?php //echo Component::get("OpenLaunchForum.Top", array("page" => $page)) ?>
	</div>-->
	<div class="forum-sidebar responsive" data-require="1000" data-width="300">
		<div class="forum-sidebar-inner">
			<div class="forum-sidebar-item forum-sidebar-discussion">
				<h2>Latest Discussions</h2>
				<?php foreach ($discussions as $discussion) { ?>
				<div class="forum-sidebar-discussion-item">
					<h3><?php echo $discussion->get("name") ?></h3>
					<h4><?php echo $discussion->getCreated() ?></h4>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="forum-categories">
		<?php foreach ($categories as $category) if ($category->canView()) { ?>
		<div class="forum-category">
			<div class="forum-category-inner">
				<h2><?php echo $category->get("name") ?></h2>
				<div class="forum-forums">
					<?php $forums = Forum::findAll("Forum", array("category" => $category)) ?>
					<?php foreach ($forums as $forum) if ($forum->canView()) { ?>

						<?php
						$last = ForumTopic::findAll("ForumTopic", array("forum"=>$forum,"hidden"=>"0"), "`cs_modified` DESC", 1, 1);
						$comment = Comment::findAll("Comment", array("modeltype" => "ForumTopic", "model"=>$last[0]), "`cs_modified` DESC");
						//echo count($last).",";
						//echo count($comment);
						?>

					<div class="forum-forum">
						<?php if (count($last) > 0 && count($comment) > 0) { $last = $last[0]; $comment = $comment[0] ?>
						<div class="forum-forum-right responsive" data-require="700">
							<div><a href="<?php echo $page->getLink("topic/".$last->getId()."/") ?>"><?php echo $last->get("name") ?></a></div>
							<div><?php echo $comment->get("user")->getName() ?> <?php echo $comment->getCreated() ?></div>
						</div>
						<?php } ?>
						<div class="forum-forum-inner"><a href="<?php echo $page->getLink("forum/".$forum->getId()."/") ?>">
							<img src="Images/Flat/Eskridge/SpeechBubbles/Blue/BlueSimple.png" />
							<h3><?php echo $forum->get("name") ?></h3>
							<div class="forum-forum-description"><?php echo $forum->get("description") ?></div>
						</a></div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
