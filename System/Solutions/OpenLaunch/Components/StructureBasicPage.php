
 <script type="text/javascript">
$(document).ready(function() {
	$(".admin-page-type-basic").height($(window).height()-120);
});
</script>

<form action="" method="post">
	<div class="admin-page-type-basic">
		<?php echo Component::get("OpenLaunch.RichTextEditor", array("id" => $id, "content" => $page->get("html"))) ?>
	</div>
</form>