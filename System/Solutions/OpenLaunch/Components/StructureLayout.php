<div class="admin-page-wrap" data-id="<?php echo ($page instanceof Page) ? $page->getId() : "" ?>">
	<div class="admin-entries-top">
		<div class="admin-entries-top-inner">
			<div class='admin-entries-button admin-menu-item-publish'>Publish</div>
			<div class='admin-entries-button admin-menu-item-settings'>Settings</div>
			<div class='admin-entries-button admin-menu-item-banner'><a href="/admin/index/structure/layout/<?php echo $page->getId() ?>/">Layout</a></div>
			<h2>
				<?php echo ($page instanceof Page) ? $page->get("name") : "New Page" ?>
				<span class="admin-breadcrumbs">
					<a href="admin/index/structure/index/">Pages /</a>
					<a href="admin/index/structure/page/<?php echo $page->getId() ?>/"><?php echo $page->get("name") ?> /</a>
					<a href="admin/index/structure/page/<?php echo $page->getId() ?>/layout/">Layout /</a>
				</span>
			</h2>
		</div>
	</div>
	<script type="text/javascript">

	</script>
	<div class="dialog banner-types">

	</div>
	<div class="admin-entries-header">
		<div class="admin-entries-header-inner">
			<div class="admin-entry-options">
				<a href="admin/index/structure/layout/<?php echo $page->getId() ?>/#" class="add">Add a Banner</a>
			</div>
			<h2>Banners</h2>
		</div>
	</div>
	<?php if ($form != "") { ?>
	<?php echo $form ?>
	<?php } else { ?>
	<div class="admin-entry">
		<div class="admin-entry-inner">
			A banner is an image or text at the top of a page
			below the navigation bar which describes what a
			page is.
			This page does not currently display a banner.
			To add one, click on the link to the top right.
		</div>
	</div>
	<?php } ?>
</div>