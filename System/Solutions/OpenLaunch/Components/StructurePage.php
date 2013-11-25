<?php
$pageId = ($page instanceof Page) ? $page->get("id") : "0";
?><script type="text/javascript">
	$(document).ready(function() {
		var id = $(".admin-page-wrap").attr("data-id");
		var pageVisible = false;

		if (id != "") {
			pageVisible = true;
			$(".admin-page-settings-outer").hide();
		}

		$(".admin-menu-item-settings").click(function() {
			pageVisible = !pageVisible;
			if (pageVisible) {
				$(".admin-page-settings-outer").hide();
			} else {
				$(".admin-page-settings-outer").show();
			}
		});


	});
</script>
<div class="admin-page-wrap" data-id="<?php echo ($page instanceof Page) ? $page->getId() : "" ?>">
	<div class="admin-entries-top">
		<div class="admin-entries-top-inner">
			<div class='admin-entries-button admin-menu-item-publish'>Publish</div>
			<div class='admin-entries-button admin-menu-item-settings'>Settings</div>
			<h2><?php echo ($page instanceof Page) ? $page->get("name") : "New Page" ?> <a href='/admin/index/structure/'>back</a></h2>
		</div>
	</div>
	<div class="admin-page-top">
		<div class="admin-page-settings-outer">
			<div class="admin-page-settings">
				<?php echo $form ?>
			</div>
		</div>
	</div>
	<div class="admin-page-content">
		<?php if (($page instanceof Page) && $page->getType() == null) { ?>
			<div class="admin-page-types">
				<?php foreach (PageType::getTypes() as $type) { ?><a href="/admin/index/structure/page/<?php echo $pageId ?>/<?php echo get_class($type) ?>"><div class="admin-page-type" style="background-image:url(<?php echo $type->getIcon() ?>)">
							<div class="admin-page-type-text"><?php echo $type->getName() ?></div>
						</div></a><?php } ?>
			</div>
		<?php } else if ($page instanceof Page) { ?>
			<?php echo $admin ?>
		<?php } ?>
	</div>
</div>