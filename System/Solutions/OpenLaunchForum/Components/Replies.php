<div class="forum">
    <div class="forum-navigation">
        <?php echo Component::get("OpenLaunchForum.Top", array("page" => $page)) ?>
    </div>
    <?php foreach ($replies as $reply) { ?>
    <?php echo Component::get("OpenLaunch.Comment", array("comment" => $reply)) ?>
    <?php } ?>
</div>