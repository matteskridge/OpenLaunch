<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>OpenLaunch</title>
		<base href="<?php echo Request::getBase() ?>/">
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="JavaScript/jquery-1.9.0.js"></script>
		<script type='text/javascript' src='JavaScript/jquery.color.js'></script>
		<script type='text/javascript' src='JavaScript/jquery-ui-1.10.3.custom.min.js'></script>
		<script type='text/javascript' src='JavaScript/TinyMCE/tinymce.min.js'></script>
		<script type="text/javascript" src="JavaScript/to-markdown.js"></script>
		<link type="text/css" rel="stylesheet" href="notheme.css" />
		<?php if (!$nowrap) { ?><link type="text/css" rel="stylesheet" href="theme.css" /><?php } ?>
	</head>
	<body>
		<div class="wrap">
			<?php echo Component::get("OpenLaunch.AdminTop") ?>
			<?php
			if (isset($nowrap) && $nowrap) {
				echo $content;
			} else {
				?>
				<?php echo Component::get("Framework.Website", $content) ?>
			<?php } ?>
			<?php echo Component::get("OpenLaunch.AdminBottom") ?>
		</div>
	</body>
</html>