<?php if ($comment->get("hidden")) { ?>
<script type="text/javascript">
    $(document).ready(function() {
        $(".comment-<?php echo $comment->getId() ?>").animate({opacity:0.3},0);
    });
</script>
<?php } ?>
<div class="comment comment-<?php echo $comment->getId() ?>">
	<div class="comment-inner">
		<div class="comment-left">
			<div class="comment-left-inner">
				<div class="comment-left-avatar">
					<?php echo $comment->get("user")->getAvatar(120) ?>
				</div>
				<div class="comment-left-title">
					<?php echo $comment->get("user")->getTitle() ?>
				</div>
			</div>
		</div>
		<div class="comment-main">
			<div class="comment-top">
				<div class="comment-top-right">
                    <?php if (Session::loggedIn() && Permission::can("CommunityModerate") && Session::getPerson()->canControl($comment->get("user"))) { ?>
                        <?php if ($comment->get("hidden")) { ?>
                        <a href="admin/index/community/comments/unhide/<?php echo $comment->get("id") ?>/?sid=<?php echo session_id() ?>">unhide</a> -
                        <?php } else { ?>
                        <a href="admin/index/community/comments/hide/<?php echo $comment->get("id") ?>/?sid=<?php echo session_id() ?>">hide</a> -
                        <?php } ?>
                    <?php } ?>
					<?php echo $comment->getCreated() ?>
				</div>
				<?php echo $comment->get("user")->getName() ?> said...
			</div>
			<?php echo Parser::parse($comment->get("content")) ?>
		</div>
	</div>
</div>