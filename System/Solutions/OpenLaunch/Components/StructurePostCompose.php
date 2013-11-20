<?php
$name = (isset($post))?$post->get("name"):"";
$content = (isset($post))?$post->get("content"):"";
$cat = (isset($post))?$post->get("page")->getId().",".$post->get("category")->getId():"";
?><script text='text/javascript'>
$(document).ready(function() {
	$(".blog-compose-main").height($(window).height()-180);
});
</script>
<form action="?sid=<?php echo session_id() ?>" method="post" class="blog-post-form">
	<div class='blog-compose-settings'>
		<div class="blog-compose-settings-inner">
			Post Title:<input type='text' name='blogpost-name' value='<?php echo $name ?>' /><select name="blogpost-category">
				<?php foreach (Page::findAll("Page", array("template" => "BlogPageType")) as $page) { ?>
				<optgroup label="<?php echo $page->get("name") ?>">
					<option value="<?php echo $page->getId() ?>,0"<?php if ($cat == $page->getId().",0") { ?> selected="yes"<?php } ?>>No Category</option>
					<?php foreach (BlogCategory::findAll("BlogCategory", array("page" => $page)) as $cat) { ?>
					<?php $cat2 = $page->getId().",".$cat->getId() ?>
					<option value="<?php echo $cat2 ?>"<?php if ($cat == $cat2) { ?> selected="yes"<?php } ?>><?php echo $cat->get("name") ?></option>
					<?php } ?>
				</optgroup>
				<?php } ?>
			</select>
		</div>
	</div><div class='blog-compose-main'>
		<?php echo Component::get("OpenLaunch.RichTextEditor", array("id" => "blogpost-text", "content" => Parser::parse($content))) ?>
	</div>
</form>