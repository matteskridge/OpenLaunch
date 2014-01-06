<div class="resolution-main">
	<div class="resolution-main-inner">
		<h2>Your Account has been Suspended</h2>
		<p>Dear <?php echo Session::getPerson()->getName() ?>,</p>

		<p>
			Your account has been temporarily suspended for violation of
			this website's terms of service and guidelines. This suspension
			will last for a total of <?php echo $suspend->getLength() ?> days,
			and will expire on
			<?php echo gmdate("F d, Y", $suspend->get("expires")) ?>.
			If you attempt in any way to circumvent this suspension,
			legal action may be taken. The following was given as the
			reason for this action.
		</p>

		<?php echo Parser::parse($suspend->get("reason")) ?>

		<p>
			This suspension is temporary, and you can still continue
			using this website once it expires. If you, in future,
			follow this website's guidelines and terms of service,
			then your account will not be further penalized.
		</p>

		<p>Moderator Team</p>
		<p><?php echo Settings::get("website.organization") ?></p>
	</div>
</div>