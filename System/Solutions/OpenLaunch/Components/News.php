<?php $data = Syndication::getLatestNews() ?>
<?php if (is_array($data)) { ?>
<div class="openlaunch-news">

	<h2>OpenLaunch News: <?php echo $data["name"] ?></h2>
	<?php echo Parser::parse($data["content"]) ?>
</div>
<?php } else { ?>
<div class="openlaunch-news">
    <?php echo $data ?>
</div>
<?php } ?>