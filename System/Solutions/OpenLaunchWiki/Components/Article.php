<div class="wiki">
	<div class="wiki-article">
		<div class="wiki-article-inner">
			<div class="wiki-back">
				<a href="<?php echo $page->getLink() ?>">Back</a>
			</div>
			<h1><?php echo $article->get("name") ?></h1>
			<?php echo Parser::parse($article->get("content")) ?>
		</div>
	</div>
</div>