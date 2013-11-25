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
		<table>
			<tr>
				<td class="account-login-left">
					<div onclick="window.location='/account/access/'"><a href="/account/access/">Sign In with OpenID</a></div>
					<div onclick="window.location='/account/access/register/'"><a href="/account/access/register/">Create an Account</a></div>
					<div onclick="window.location='/account/access/signin/'"><a href="/account/access/signin">Sign In</a></div>
					<div onclick="window.location='/account/access/recover/'"><a href="/account/access/recover/">Recover Password</a></div>
				</td>
				<td class="account-login-right">
					<?php if ($action == "") { ?>
					Before you can access some features of this website, you will need to
					sign in. This can be accomplished by selecting one of the three supported
					openID providers above and signing in through them. You can do this if you
					already have a Google, Yahoo, or AOL account. If you do not have any of these,
					and do not want to register with them, then you are free to select the
					"create an account" option to the left.

					<a href="/account/access/url/">Sign in with an OpenID URL</a>
					or
					<a href="#">Click a logo</a>
					<?php } else if ($action == "register") { ?>
					<?php echo $register ?>
					<?php } else if ($action == "signin") { ?>
					<?php echo $form ?>
					<?php } else if ($action == "url") { ?>

					<?php echo $url ?>
					<p style="text-align:center;">
						Don't Know? Click one of the logos above.
					</p>
					<?php } else if ($action == "recover") { ?>
					We currently do not offer account recovery. This feature will be added soon. Until then, we
					recommend using the openID sign-on options above.
					<?php } ?>
				</td>
			</tr>
		</table>
		</div>
	</div>
</div>