<div class="openlaunch-news">
	<?php $data = Syndication::getLatestNews() ?>
	<h2>OpenLaunch News: <?php echo $data["name"] ?></h2>
	<?php echo Parser::parse($data["content"]) ?>
</div>