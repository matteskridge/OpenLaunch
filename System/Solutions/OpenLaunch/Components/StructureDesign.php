<script type='text/javascript'>
$(document).ready(function() {
	$(".admin-design").click(function() {
		$(".admin-design").each(function() {
			$(this).removeClass("selected");
		});
		$(this).addClass("selected");
		
		var id = $(this).attr("data-id");
		
		$.ajax({
			url: "theme/info/"+id+"/",
			success: function(html) {
				$(".admin-designs-info-inner").html(html);
			}
		});
	})
});
</script>
<div class='admin-structure-design'>
	<div class="admin-entries-top">
		<div class="admin-entries-top-inner">
			<h2>Design Center</h2>
		</div>
	</div>
	<div class='admin-designs'>
		<div class='admin-designs-list'>
			<h2>Avaliable Themes</h2>
			<div class="admin-designs-scroll">
				<?php foreach (ThemeProcess::getThemes() as $theme) { ?><div class='admin-design' data-id='<?php echo $theme->getId() ?>'>
					<?php echo $theme->getImageHtml(248,141) ?>
				</div><?php } ?>
			</div>
		</div><div class='admin-designs-info'>
			<div class='admin-designs-info-inner'>
				
			</div>
		</div>
	</div>
</div>