<div class="comment">
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
					<?php echo $comment->getCreated() ?>
				</div>
				<?php echo $comment->get("user")->getName() ?> said...
			</div>
			<?php echo Parser::parse($comment->get("content")) ?>
		</div>
	</div>
</div>