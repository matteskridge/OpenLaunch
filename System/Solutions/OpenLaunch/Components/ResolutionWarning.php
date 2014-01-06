<script type="text/javascript">
	$(document).ready(function() {
		$(".show-after-delay").hide();
		setTimeout(function() {
			$(".show-before-delay").hide();
			$(".show-after-delay").show();
		}, 30000);
	});
</script>
<div class="resolution-main">
	<div class="resolution-main-inner">
		<h2>Urgent Warning</h2>
		<p>Dear <?php echo Session::getPerson()->getName() ?>,</p>

		<p>
			You have violated this website's guidelines or terms of
			service. Please read and acknowledge the below note before
			using this website further. If you do not abide by the instructions
			which are contains within this warning, your account will be
			suspended.
		</p>

		<?php echo Parser::parse($warn->get("reason")) ?>

		<p>
			To acknowledge this warning, please solve the CAPTCHA which
			will appear below after you have been given sufficent time to
			read this notice. Thank you.
		</p>

		<div class="show-before-delay">
			<p>The option to confirm this message will appear in 30 seconds...</p>
		</div>

		<div class="show-after-delay">
			<?php echo $form ?>
		</div>

		<p>Moderator Team</p>
		<p><?php echo Settings::get("website.organization") ?></p>
	</div>
</div>