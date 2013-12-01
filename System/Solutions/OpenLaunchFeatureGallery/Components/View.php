<div class="featuregallery">
	<?php foreach ($categories as $cat) { ?>
	<div class="featuregallery-category">
		<h2><?php echo $cat->get("name") ?></h2>
		<div class="featuregallery-items">
			<?php foreach (FeatureGalleryEntry::findAll("FeatureGalleryEntry", array("category" => $cat)) as $item) { ?>
			<div class="featuregallery-item">
				<h3><?php echo $item->get("name") ?></h3>
				<img src="<?php echo Request::getBase().$item->get("image")->getLink(256) ?>" />
				<div class="featuregallery-item-inner">
					<?php echo Parser::parse($item->get("description")) ?>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
	<?php } ?>
</div>