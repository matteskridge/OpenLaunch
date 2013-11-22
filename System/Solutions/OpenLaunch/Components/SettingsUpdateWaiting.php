<script type="text/javascript">
	$(document).ready(function() {
		$.ajax({
			url: "setup.php",
			success: function() {
				window.location = "/";
			}
		});
	});
</script>
<div class="admin-entry">
	<div class="admin-entry-inner">
		<?php echo Component::get("OpenLaunch.Loading") ?>
	</div>
</div>