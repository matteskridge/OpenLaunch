<script type="text/javascript">
$(document).ready(function() {
	$(".admin-menu-item-publish").click(function() {
		$(".admin-main-inner form").submit();
	});
});
</script>
<div class="admin">
	<div class="admin-menu">
		<div class="admin-menu-inner">
			<?php if ($action == "page") { ?>
			<div class="admin-menu-right">
				<div class="admin-menu-item admin-page-settings-button">Settings</div>
				<div class="admin-menu-item admin-menu-item-publish">Publish</div>
			</div>
			<?php } ?>
			<a href="/admin/index/structure/"><div class="admin-menu-item">Structure</div></a>
			<a href="/admin/index/structure/posts/"><div class="admin-menu-item">Posts</div></a>
			<a href="/admin/index/structure/design/"><div class="admin-menu-item">Design</div></a>
			<a href="/admin/index/structure/upgrade/"><div class="admin-menu-item">Upgrade</div></a>
		</div>
	</div>
	<div class="admin-main">
		<div class="admin-main-inner">
			<?php echo $content ?>
		</div>
	</div>
</div>
