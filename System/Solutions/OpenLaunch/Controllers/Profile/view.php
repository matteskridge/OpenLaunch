<div class="profile">
	<div class="profile-inner">
		<div class="profile-top">
			<div class="profile-top-inner">
				<div class="profile-top-avatar">
					<?php echo $person->getAvatar(128) ?>
				</div>
				<div class="profile-top-details">
					<div class="profile-top-name"><?php echo $person->getName() ?></div>
					<div class="profile-top-title"><?php echo $person->getTitle() ?></div>
				</div>
			</div>
		</div>
		<div class="profile-main">
			<div class="profile-main-inner">
				<div class="profile-entry">
					<div class="profile-entry-inner">
						<h2>Profile</h2>
						<div class="profile-entry-text">
							<?php echo Parser::parse($person->getProfile()) ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
