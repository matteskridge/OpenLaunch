<div class="communications">
	<div class="admin-entries-top">
		<div class="admin-entries-top-inner">
			<h2>Communication Center</h2>
		</div>
	</div>
	<?php foreach ($communications as $item) { ?>
	<div class="communication">
		<div class="communication-inner">
			<div class="communication-right">
				<a href="mailto:<?php echo $item->get("email") ?>"><?php echo $item->get("email") ?></a> (<?php echo $item->get("phone") ?>)
			</div>
			<h2><?php echo $item->get("name") ?></h2>
			<?php echo Parser::parse($item->get("content")) ?>
		</div>
	</div>
	<?php } ?>
	<div class="communication communication-last">
		Messages from contact forms go here
	</div>
</div>