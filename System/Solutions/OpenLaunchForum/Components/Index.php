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
					<div class="forum-forum">
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