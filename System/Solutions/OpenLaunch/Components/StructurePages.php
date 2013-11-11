<!--<script type="text/javascript">
$(document).ready(function() {
	$(".admin-pages").css({marginLeft:(($(window).width()/2)-500)+"px"});
})
</script>-->
<div class="admin-pages">
	<?php foreach (Page::findAll("Page", array("parent" => "0")) as $page) { ?><div class="admin-page">
		<a href="/admin/index/structure/page/<?php echo $page->get("id") ?>"><div class="admin-page-item-top" style="background-image:url(<?php echo $page->getIcon() ?>);"><div class="admin-page-name"><?php echo $page->get("name") ?></div></div></a>
		<div class="admin-page-subs">
			<?php foreach ($data = Page::findAll("Page", array("parent" => $page)) as $sub) { ?>
			<div class="admin-page-sub" style="background-image:url(<?php echo $sub->getIcon() ?>);"><a href="/admin/index/structure/page/<?php echo $sub->get("id") ?>/"><?php echo $sub->get("name") ?></a></div>
			<?php } if (count($data) == 0) { ?>
			<div class="admin-page-sub">No Sub-Pages Yet</div>
			<?php } ?>
		</div>
		<div class="admin-page-sub admin-page-sub-add"><a href="/admin/index/structure/page/0/<?php echo $page->get("id") ?>">Create Sub-Page</a></div>
    </div><?php } ?><a href="/admin/index/structure/page/"><div class="admin-page admin-page-index-add">
		<div class="admin-page-item-top admin-page-add"><div class="admin-page-name">Create Page</div></div>
    </div></a>
</div>