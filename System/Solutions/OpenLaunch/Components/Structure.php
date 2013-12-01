<script type="text/javascript">
	$(document).ready(function() {
		$(".admin-menu-item-publish").click(function() {
			$(".admin-main-inner form").submit();
		});
	});
</script>
<div class="admin">
	<div class="admin-main">
		<div class="admin-main-inner">
			<?php echo $content ?>
		</div>
	</div>
</div>
