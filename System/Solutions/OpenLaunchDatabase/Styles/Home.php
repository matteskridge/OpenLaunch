
<div class="database-entries">
	<?php foreach ($items as $item) { ?>
		<div class="database-entry">
			<?php echo $item->get("name") ?>
		</div>
	<?php } ?>
</div>