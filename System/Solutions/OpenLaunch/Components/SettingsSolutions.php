<?php if (isset($form)) { ?>
	<div class="settings-roles">
		<?php echo $form ?>
	</div>
<?php } else { ?>
	<div class="settings-roles">
		<?php foreach ($solutions as $solution) { ?>
			<div class="settings-role">
				<div class="settings-role-inner">
					<div class="settings-role-right">
						<?php if ($solution->isCore()) { ?>
							This plugin cannot be deactivated -
						<?php } ?>
						<a href="<?php echo $solution->getAuthorWebsite() ?>"><?php echo $solution->getAuthor() ?></a>
					</div>
                    <?php if ($solution->getName() == "") { ?>
                    <?php echo $solution->getFile()->getExtensionlessName() ?>
                    <?php } else { ?>
					<?php echo $solution->getName() ?>
                    <?php } ?>
				</div>
			</div>
		<?php } ?>
	</div>
<?php } ?>