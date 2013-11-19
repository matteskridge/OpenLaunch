<script type="text/javascript">
	$(document).ready(function() {
		$(".admin-pages").sortable({
			handle: ".admin-page-item-top"
		});
	})
</script>
<div class="admin-entries">
	<div class="admin-entries-top">
		<div class="admin-entries-top-inner">
			<div class='admin-entries-button'><a href="/admin/index/structure/page/0/">Create Page</a></div>
			<h2>Page Center</h2>
		</div>
	</div>
	<?php foreach (Page::listAll() as $page) { ?>
		<div class="admin-entry">
			<div class="admin-entry-inner">
				<div class="admin-entry-options">
					<img src="/Images/Black/IconFinder/Move.png" />
					<img src="/Images/Black/IconFinder/Delete.png" />
				</div>
				<div class='admin-entry-inner-main' style='padding-left:<?php echo $page->indention() ?>px;'>
					<a href='/admin/index/structure/page/<?php echo $page->getId() ?>/'><?php echo $page->get("name") ?></a>
				</div>
			</div>
		</div>
	<?php } ?>
</div>