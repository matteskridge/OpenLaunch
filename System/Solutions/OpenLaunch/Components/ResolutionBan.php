<div class="resolution-main">
	<div class="resolution-main-inner">
		<h2>Your Account has been Banned</h2>
		<p>Dear <?php echo Session::getPerson()->getName() ?>,</p>

		<p>
			Your account has been permanently suspended for violation of
			this website's terms of service and guidelines. Unfortunately,
			there is no option to appeal this restriction, and it is not
			set to expire, unless a website administrator chooses to
			explicitly revoke the suspension. Continuing to use this
			website, despite the suspension of your account, can result
			in legal action against you.
		</p>

		<p>Moderator Team</p>
		<p><?php echo Settings::get("website.organization") ?></p>
	</div>
</div>