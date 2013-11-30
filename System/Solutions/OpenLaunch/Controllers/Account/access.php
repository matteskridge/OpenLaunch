<script type="text/javascript">
	$(document).ready(function() {
		$(".account-auth-google").click(function() {
			window.location = "/account/openid/google/";
		});
		$(".account-auth-yahoo").click(function() {
			window.location = "/account/openid/yahoo/";
		});
		$(".account-auth-aol").click(function() {
			window.location = "/account/openid/aol/";
		})
	});
</script>

<div class="account-access">
	<div class="account-auth">
		<div class="account-auth-inner">
			<div class="account-auth-aol">

			</div>
			<div class="account-auth-google">

			</div>
			<div class="account-auth-yahoo">

			</div>
		</div>
	</div>
	<div class="account-login">
		<div class="account-login-inner">
			<div class="account-login-signup">
				<h2>Create an Account</h2>
				<?php echo $signup ?>
			</div>
			<div class="account-login-signin">
				<h2>Sign-In</h2>
				<?php echo $signin ?>
			</div>
		</div>
	</div>
</div>