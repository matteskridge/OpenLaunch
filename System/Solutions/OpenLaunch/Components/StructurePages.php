<div class="admin-pages">
	<?php foreach (Page::findAll("Page") as $page) { ?><a href="/admin/index/structure/page/<?php echo $page->get("id") ?>"><div class="admin-page" style="background-image:url(<?php echo $page->getIcon() ?>);">
		<div class="admin-page-name"><?php echo $page->get("name") ?></div>
    </div></a><?php } ?><a href="/admin/index/structure/page/"><div class="admin-page admin-page-add">
        <div class="admin-page-name">Create Page</div>
    </div></a>
</div>