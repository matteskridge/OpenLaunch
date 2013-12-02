<?php $last = Comment::findAll("Comment", array("modeltype" => "ForumTopic", "model" => $topic->getId()), "`cs_modified` DESC", 1, 1) ?>
<?php $replies = Comment::count("Comment", array("modeltype" => "ForumTopic", "model" => $topic->getId())) ?>
<div class="forum-topics-topic">
    <div class="forum-topics-topic-inner">
        <?php if ($replies > 1) { $last = $last[0] ?>
            <div class="forum-topics-topic-last">
                <div><?php echo ($replies == 2)?"Reply":"Replies" ?>. Last by <?php echo $last->get("user")->getName() ?></div>
                <div><?php echo $last->getCreated() ?></div>
            </div>
            <div class="forum-topics-topic-replies">
                <?php echo $replies-1 ?>
            </div>
        <?php } ?>
        <a href="<?php echo $topic->get("user")->getProfileLink() ?>"><div class="forum-topics-topic-avatar">
                <?php echo $topic->get("user")->getAvatar(48) ?>
            </div></a><a href="<?php echo $topic->getLink($page) ?>"><div class="forum-topics-topic-details">
                <div class="forum-topics-topic-name">

                    <?php if ($topic->get("closed")) { ?>
                        <img src="Images/Black/IconFinder/Lock.png" />
                    <?php } ?>

                    <?php if ($topic->get("pinned")) { ?>
                        <img src="Images/Black/IconFinder/Pin.png" />
                    <?php } ?>

                    <?php if ($topic->get("hidden")) { ?>
                        <img src="Images/Black/IconFinder/Delete.png" />
                    <?php } ?>

                    <?php echo $topic->get("name") ?>
                </div>
                <div class="forum-topics-topic-info">
                    by <?php echo $topic->get("user")->getName() ?> <?php echo $topic->getCreated() ?>.
                </div>
            </div></a>
    </div>
</div>