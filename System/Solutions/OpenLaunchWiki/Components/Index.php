<div class="wiki">
	<div class="wiki-mainpage">
		<div class="wiki-mainpage-inner">
			<h1><?php echo $page->get("name") ?></h1>
			<div class="wiki-mainpage-text">
				<?php echo Parser::parse($page->get("html")) ?>
			</div>
		</div>
	</div>
	<div class="wiki-categories">
		<?php foreach ($categories as $category) { ?>
			<div class="wiki-category">
				<div class="wiki-category-inner">
					<h2><?php echo $category->get("name") ?></h2>
					<div class="wiki-articles">
						<?php foreach(WikiPage::findAll("WikiPage", array("category" => $category)) as $article) { ?>
							<div class="wiki-article">
								<a href="<?php echo $page->getLink("article/".$article->getId()."/") ?>"><?php echo $article->get("name") ?></a>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>