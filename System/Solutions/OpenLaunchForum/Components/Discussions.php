<div class="forum">
    <div class="forum-navigation">
        <?php echo Component::get("OpenLaunchForum.Top", array("page" => $page)) ?>
    </div>
    <div class="forum-categories">
        <div class="forum-topics">
            <h2>Recent Discussions</h2>
            <div class="forum-topics-inner">
                <?php foreach ($discussions as $topic) { ?>
                    <?php echo Component::get("OpenLaunchForum.TopicItem", array("page"=>$page,"topic"=>$topic)) ?>
                <?php } ?>
                <?php if (count($discussions) == 0) { ?>
                    <div class="forum-topics-empty-notice">
                        There are no topics to display.
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>