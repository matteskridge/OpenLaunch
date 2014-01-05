<div class="topmenu responsive-menu" data-responsive-subtract="menu-right">
	<?php foreach (Page::findAll("Page", array("parent" => "0"), "`order`,`id`") as $page) { ?><div class="menu-item"><a href="<?php echo $page->getLink() ?>"><?php echo $page->get("name") ?></a></div><?php } ?>
</div>