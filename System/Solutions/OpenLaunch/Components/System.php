<script type="text/javascript">
	$(document).ready(function() {
		$.ajax({
			url: "/api/news/",
			success: function(html) {
				$(".admin-ajax-news").html(html);
			}
		});
	});
</script>
<div class="admin-entries">
	<div class="admin-entry">
		<div class="admin-entry-inner">
			<div class="admin-entry-column">
				<div class="admin-entry-column-inner">
					<img src="Images/Flat/IconFinder/Settings.png" />
					<h2>Software Version</h2>
					This website is currently using version <?php echo PRODUCT_BUILD ?> of OpenLaunch. Check below
					for urgent update news.
				</div>
			</div>
			<div class="admin-entry-column">
				<div class="admin-entry-column-inner">
					<img src="Images/Flat/IconFinder/Question.png" />
					<h2>OpenLaunch Support</h2>
					Need help with OpenLaunch? Visit our support forums or read the online documentation.
				</div>
			</div>
		</div>
	</div>
	<div class="admin-entry">
		<div class="admin-entry-inner">
			<div class="admin-ajax-news"><?php echo Component::get("OpenLaunch.Loading") ?></div>
		</div>
	</div>
</div>