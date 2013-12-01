<div class="forum">
	<div class="forum-navigation">

	</div>
	<div class="forum-categories">
		<?php foreach ($categories as $category) { ?>
		<div class="forum-category">
			<div class="forum-category-inner">
				<h2><?php echo $category->get("name") ?></h2>
				<div class="forum-forums">
					<?php $forums = Forum::findAll("Forum", array("category" => $category)) ?>
					<?php foreach ($forums as $forum) { ?>

						<?php
						$last = ForumTopic::findAll("ForumTopic", array("forum"=>$forum,"hidden"=>"0"), "`cs_modified` DESC", 1, 1);
						$comment = Comment::findAll("Comment", array("modeltype" => "ForumTopic", "model"=>$last[0]), "`cs_modified` DESC");
						//echo count($last).",";
						//echo count($comment);
						?>

					<div class="forum-forum">
						<?php if (count($last) > 0 && count($comment) > 0) { $last = $last[0]; $comment = $comment[0] ?>
						<div class="forum-forum-right">
							<div><a href="<?php echo $page->getLink("topic/".$last->getId()."/") ?>"><?php echo $last->get("name") ?></a></div>
							<div>Reply by <?php echo $comment->get("user")->getName() ?></div>
						</div>
						<?php } ?>
						<div class="forum-forum-inner"><a href="<?php echo $page->getLink("forum/".$forum->getId()."/") ?>">
							<img src="Images/Flat/IconFinder/Forum.png" />
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