
<div class='theme-sidebar'>
	<h2><?php echo $theme->getName() ?> : <?php echo $theme->getVariant() ?></h2>
	<div style='text-align:center;'>
		<?php echo $theme->getImageHtml(450, 253) ?>
	</div>
	<div class='theme-sidebar-item'>
		<label>Activate:</label><a href='admin/index/structure/design/<?php echo $theme->getId() ?>'>Use this Theme</a>
	</div>
	<div class='theme-sidebar-item'>
		<label>Author:</label><a href='<?php echo $theme->getAuthorWebsite() ?>' target='_blank'><?php echo $theme->getAuthorName() ?></a>
	</div>
</div>
