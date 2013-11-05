<div class="admin-pages">
	<?php foreach (Page::findAll("Page") as $page) { ?>
		<div class="admin-page">
			<div class="admin-page-name"></div>
		</div>
	<?php } ?>
	<a href="/admin/index/structure/page/"><div class="admin-page admin-page-add">
			<div class="admin-page-name">Create Page</div>
		</div></a>
</div>