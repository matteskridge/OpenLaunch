<div class="database">
	<div class="database-sidebar responsive" data-require="800" data-width="300">
		<h2>Categories</h2>
		<div class="database-categories">
			<?php foreach ($categories as $cat) { ?>
				<div class="database-category">
					<?php echo $cat->get("name") ?>
				</div>
			<?php } ?>
		</div>
	</div>
	<div class="database-main">
		<?php echo $content ?>
	</div>
</div>