
 <script type="text/javascript">
$(document).ready(function() {
	$(".admin-compose").height($(window).height()-195);
});
</script>

<form action="" method="post">
	<div class="admin">
		<div class="admin-menu">
			<div class="admin-menu-inner">
				<div class="admin-menu-form"><label for="compose-title">Name:</label><input type="text" name="compose-title" id="compose-title" /></div>
			</div>
		</div>
		<div class="admin-main">
			<div class="admin-main-inner">

					<div class="admin-compose">
						<?php echo Component::get("OpenLaunch.RichTextEditor", array("id" => "compose-content")) ?>
					</div>

			</div>
		</div>
	</div>
</form>