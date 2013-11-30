<?php
$menu = 1;
$sidebar = 2;
?>

<div class='page'>
	<?php if (count(Page::getMenuItems($menu, $page)) != 0) { ?>
	<div class="page-menu">
		<?php foreach (Page::getMenuItems($menu, $page) as $item) { ?>
		<div class="page-menu-item<?php if ($page->getId() == $item->getId()) echo " selected"; ?>">
			<a href="page/<?php echo $item->getId() ?>/"><?php echo $item->get("name") ?></a>
		</div>
		<?php } ?>
	</div>
	<?php } ?>
	
	<table class="page-columns">
		<tr>
			<?php if (count(Page::getMenuItems($sidebar, $page)) != 0) { ?>
			<td class="page-sidebar">
				<?php foreach (Page::getMenuItems($sidebar, $page) as $item) { ?>
				<div class="page-sidebar-item<?php if ($page->getId() == $item->getId()) echo " selected"; ?>">
					<a href="page/<?php echo $item->getId() ?>/"><?php echo $item->get("name") ?></a>
				</div>
				<?php } ?>
			</td>
			<?php } ?>
			<td class="page-main">
				<div class="page-content">
					<?php echo $html ?>
				</div>
			</td>
			
		</tr>
	</table>
</div>
