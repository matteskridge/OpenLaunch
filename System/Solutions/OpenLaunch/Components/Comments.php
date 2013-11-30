<div class="comments">
	<div class="comments-list">
		<?php foreach ($comments as $comment) { ?>
		<?php echo Component::get("OpenLaunch.Comment", array("comment" => $comment)) ?>
		<?php } ?>
	</div>
	<?php if (!$locked && Session::loggedIn()) { ?>
	<div class="comments-add">
		<div class="comments-add-inner">
			<?php echo $form ?>
		</div>
	</div>
	<?php } ?>
</div>