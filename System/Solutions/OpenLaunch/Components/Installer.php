<html>
	<head>
		<title>OpenLaunch Installer</title>
		<base href="http://<?php echo Request::getDomain() ?>/<?php echo Request::getUrl() ?>" />
		<link rel="stylesheet" type="text/css" href="/Styles/Installer.css" />
		<script type="text/javascript" src="JavaScript/jquery-1.9.0.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$(".installer-provider-google").click(function() {
					window.location = "?openid=google";
				});
				$(".installer-provider-yahoo").click(function() {
					window.location = "?openid=yahoo";
				});
				$(".installer-provider-aol").click(function() {
					window.location = "?openid=aol";
				});
			});
		</script>
	</head>
	<body>
		<div class="installer">
			<div class="installer-header">
				<div class="installer-header-inner">
					<img src="Images/Logos/OpenLaunch/White.png" />
				</div>
			</div>
			<?php if ($error != "") { ?>
				<div class="installer-error">
					<?php echo $error ?>
				</div>
			<?php } ?>
			<div class="installer-main">
				<div class="installer-main-inner">
					<?php if (isset($login)) { ?>
						<h2>Sign in to your new website</h2>
						<div class="installer-select-provider">
							<div class="installer-provider installer-provider-google">
							</div>
							<div class="installer-provider installer-provider-yahoo">
							</div>
							<div class="installer-provider installer-provider-aol">
							</div>
						</div>
					<?php } else { ?>
						<form action="" method="post">
							<div class="installer-main-form-item">
								<div class="installer-main-form-item-inner">
									<label>Website Name</label>
									<input type="text" name="website-name" />
								</div>
							</div>
							<div class="installer-main-form-item">
								<div class="installer-main-form-item-inner">
									<label>Website Description</label>
									<input type="text" name="website-description" />
								</div>
							</div>
							<div class="installer-main-form-item">
								<div class="installer-main-form-item-inner">
									<label>MySQL Server</label>
									<input type="text" name="database-server" value="localhost" />
								</div>
							</div>
							<div class="installer-main-form-item">
								<div class="installer-main-form-item-inner">
									<label>MySQL Username</label>
									<input type="text" name="database-user" value="root" />
								</div>
							</div>
							<div class="installer-main-form-item">
								<div class="installer-main-form-item-inner">
									<label>MySQL Password</label>
									<input type="text" name="database-password" value="" />
								</div>
							</div>
							<div class="installer-main-form-item">
								<div class="installer-main-form-item-inner">
									<label>MySQL Database</label>
									<input type="text" name="database-name" value="openlaunch" />
								</div>
							</div>
							<div class="installer-main-form-item">
								<div class="installer-main-form-item-inner">
									<label>Install Directory</label>
									<input type="text" value="<?php echo Request::getUrl() ?>" name="website-link" />
								</div>
							</div>
							<div class="installer-submit">
								<input type="submit" value="Install Now" />
							</div>
						</form>
					<?php } ?>
				</div>
			</div>
			<div class="installer-main-push"></div>
		</div>
		<div class="installer-footer">
			<div class="installer-footer-inner">
				Built by Eskridge Technology. Copyright &copy; 2013, Eskridge Technology. <a href="https://github.com/Eskridge/OpenLaunch/blob/master/LICENSE" target="_blank">Licensed under the MIT License</a>
			</div>
		</div>
	</body>
</html>