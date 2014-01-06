<script type="text/javascript">
$(document).ready(function() {
	$(".admin-blog-publish").click(function() {
		$("form.blog-post-form").submit();
	});
});
</script>
<div class='admin-structure-design'>
	<div class="admin-entries-top">
		<div class="admin-entries-top-inner">
			<?php if ($id == "") { ?>
			<div class='admin-entries-button'><a href="admin/index/structure/posts/0/">Compose</a></div>
			<?php } else { ?>
			<div class='admin-entries-button admin-blog-publish'>Publish Now</div>
			<?php } ?>
			<h2>Blog Center<?php if ($id != "") { ?> <a href="admin/index/structure/posts/">back</a><?php } ?></h2>
		</div>
	</div>
	<?php echo Component::get("OpenLaunch.StructureMenu") ?>
	<div class="blog-center">
		<?php echo $content ?>
	</div>
</div>