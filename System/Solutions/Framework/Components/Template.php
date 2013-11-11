<html>
	<head>
		<title>OpenLaunch</title>
		<script type="text/javascript" src="/JavaScript/jquery-1.9.0.js"></script>
		<script type='text/javascript' src='/JavaScript/jquery.color.js'></script>
		<script type='text/javascript' src='/JavaScript/jquery-ui-1.10.3.custom.min.js'></script>
		<script type='text/javascript' src='/JavaScript/TinyMCE/tinymce.min.js'></script>
		<script type="text/javascript" src="/JavaScript/to-markdown.js"></script>
		<link type="text/css" rel="stylesheet" href="/notheme.css" />
		<?php if (!$nowrap) { ?><link type="text/css" rel="stylesheet" href="/theme.css" /><?php } ?>
	</head>
	<body>
		<div class="wrap">
			<?php echo Component::get("OpenLaunch.Admin") ?>
			<?php if (isset($nowrap) && $nowrap) { echo $content; } else { ?>
			<?php echo Component::get("Framework.Website", $content) ?>
			<?php } ?>
			
			<?php if (isset($nowrap) && $nowrap) { ?>
			<div class="admin-footer-push"></div>
			<?php } ?>
		</div>
		<?php if (isset($nowrap) && $nowrap) { ?>
		
		<div class="admin-footer">
			<div class="admin-footer-inner">
				Powered by <a href="http://openlaunch.org/">OpenLaunch</a>, an open source product of <a href="http://eskridgetech.com/">Eskridge Technology LLC</a>.
			</div>
		</div>
		<?php } ?>
	</body>
</html>