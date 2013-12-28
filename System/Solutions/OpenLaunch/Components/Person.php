<script type="text/javascript">
	$(document).ready(function() {
		$(".person-suspend").click(function() {
			$(".admin-person-suspend").dialog("open");
		});
		$(".person-warn").click(function() {
			$(".admin-person-warn").dialog("open");
		});
		$(".person-ban").click(function() {
			$(".admin-person-ban").dialog("open");
		});
		$(".person-edit").click(function() {
			$(".admin-person-edit").dialog("open");
		});
	});
</script>
<div class="dialog admin-person-suspend" title="Suspend Account">
	<?php echo $suspend ?>
</div><div class="dialog admin-person-warn" title="Warn Account">
	<?php echo $warn ?>
</div><div class="dialog admin-person-edit" title="Edit Account">
	<?php echo $edit ?>
</div><div class="dialog admin-person-ban" title="Ban Account">
	<?php echo $ban ?>
</div>
<div class="admin-person-wrap">
    <div class="admin-person-header">
        <div class="admin-person-header-inner">
            <div class="admin-person-header-avatar">
				<?php echo $person->getAvatar(188) ?>
            </div>
            <div class="admin-person-header-text">
                <h1><?php echo $person->get("nickname") ?> <a href='admin/index/community/'>back</a></h1>
            </div>
            <div class="admin-person-header-options">
                <div class="admin-person-header-option admin-person-header-option-dashboard">
					<div class="admin-person-header-option-inner">Dashboard</div>
				</div><?php if (Permission::can("CommunitySuspend") && $controls) { ?><div class="admin-person-header-option admin-person-header-option-suspend person-suspend">
					<div class="admin-person-header-option-inner">Suspend</div>
				</div><?php } if (Permission::can("CommunityBan") && $controls) { ?><div class="admin-person-header-option admin-person-header-option-ban person-ban">
					<div class="admin-person-header-option-inner">Ban Person</div>
				</div><?php } ?><div class="admin-person-header-option admin-person-header-option-profile">
					<div class="admin-person-header-option-inner">Profile</div>
				</div><?php if (Permission::can("CommunityStatistics") && $controls) { ?><div class="admin-person-header-option admin-person-header-option-statistics">
					<div class="admin-person-header-option-inner">Statistics</div>
				</div><?php } ?><div class="admin-person-header-option admin-person-header-option-contact">
					<div class="admin-person-header-option-inner">Contact</div>
				</div>
            </div>
        </div>
    </div>
	<div class="admin-person-main">
		<div class="admin-person-main-item">
			<div class="admin-person-main-item-inner">
				<?php if (Permission::can('RemoveProfile') && $controls) { ?><div class="admin-person-main-item-right"><a onclick="return confirm('Are you sure?')" href="admin/index/community/person/<?php echo $person->getId() ?>/?deprofile=1&sid=<?php echo session_id() ?>">Remove Profile</a></div><?php } ?>
				<h2>Public Profile</h2>
				<div class="admin-person-main-text">
					<?php echo $person->getProfile() ?>
				</div>
			</div>
		</div>
		<?php if (Permission::can("CommunityAccount")) { ?>
		<div class="admin-person-main-item">
			<div class="admin-person-main-item-inner">
				<?php if (Permission::can("CommunityEditAccount") && $controls) { ?><div class="admin-person-main-item-right person-edit"><a href="admin/index/community/person/<?php echo $person->get("id") ?>/#">Edit Details</a></div><?php } ?>
				<h2>Account Details</h2>
				<div class="admin-person-main-text">
					<table>
						<tr>
							<th style="width:250px;">Detail</th>
							<th>Value</th>
						</tr>
						<tr>
							<td>Real Name</td>
							<td><?php echo $person->getRealName() ?></td>
						</tr>
						<tr>
							<td>Email Address</td>
							<td><?php echo $person->get("email") ?></td>
						</tr>
						<tr>
							<td>Phone Number</td>
							<td><?php echo $person->getPhone() ?></td>
						</tr>
						<tr>
							<td>Address</td>
							<td><?php echo $person->getAddress() ?></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<?php } ?>
		<?php if (Permission::can("CommunityAssignRoles") && $controls) { ?>
		<div class="admin-person-main-item">
			<div class="admin-person-main-item-inner">
				<h2>Assigned Roles</h2>
				<?php
				foreach ($roles as $role) {
					$assigned = in_array($role, $person->getRoles());
					if (!Session::getPerson()->canAssign($role)) continue;
					?><div class="admin-entry-column-smaller <?php echo ($assigned) ? "assigned" : "unassigned" ?>">
						<div class="admin-entry-column-smaller-inner">
							<?php echo $role->getIcon() ?>
							<h2><?php echo $role->get("name") ?></h2>
							<?php if ($assigned) { ?>
								<a href="admin/index/community/person/<?php echo $person->getId() ?>/?unrole=<?php echo $role->getId() ?>&sid=<?php echo session_id() ?>" onclick="return confirm('Remove this person from the <?php echo $role->get("name") ?> role?')">Assigned to this Role</a>
							<?php } else { ?>
								<a href="admin/index/community/person/<?php echo $person->getId() ?>/?role=<?php echo $role->getId() ?>&sid=<?php echo session_id() ?>" onclick="return confirm('Assign this person to the <?php echo $role->get("name") ?> role?')">Not assigned to this Role</a>
							<?php } ?>
						</div>
					</div><?php } ?>
			</div>
		</div>
		<?php } ?>
		<?php if ((Permission::can("CommunitySuspend") || Permission::can("CommunityWarn") || Permission::can("CommunityBan")) && $controls && !$me) { ?>
		<div class="admin-person-main-item">
			<div class="admin-person-main-item-inner">
				<h2>Moderator Tools</h2>
				<?php if (Permission::can("CommunitySuspend") && $controls) { ?>
                <div class="admin-entry-column-smaller">
                    <div class="admin-entry-column-smaller-inner person-suspend">
                        <img src="Images/Flat/IconFinder/Delete.png" />
                        <h2>Suspend Account</h2>
                        Prevent user from signing in
                    </div>
                </div><?php } if (Permission::can("CommunityWarn") && $controls) { ?><div class="admin-entry-column-smaller">
                    <div class="admin-entry-column-smaller-inner person-warn">
                        <img src="Images/Flat/IconFinder/Warning.png" />
                        <h2>Issue Warning</h2>
                        warning user must acknowledge.
                    </div>
                </div><?php } if (Permission::can("CommunityBan") && $controls) { ?><div class="admin-entry-column-smaller">
                    <div class="admin-entry-column-smaller-inner person-ban">
                        <img src="Images/Flat/IconFinder/Remove.png" />
                        <h2>Ban Account</h2>
                        Permenant account suspension
                    </div>
               </div><?php } ?>
			</div>
			<?php if (count($suspensions) != 0) { ?>
			<div class="admin-person-main-text">
				<table>
					<tr>
						<th style="width:150px;">When</th>
						<th style="width:100px;">What</th>
						<th>Reason</th>
						<th style="width:200px;">Actions</th>
					</tr>
					<?php foreach ($suspensions as $suspend) { ?>
					<tr class="admin-table-<?php echo $suspend->getColor() ?>">
						<td><?php echo $suspend->getCreated() ?></td>
						<td><?php echo $suspend->getType() ?></td>
						<td>
							<?php echo Parser::parse($suspend->get("reason")) ?>
						</td>
						<td>
							<?php if ($suspend->get("revoked")) { ?>
								<a href="admin/index/community/person/7/?reinstate=<?php echo $suspend->getId() ?>&authorize=<?php echo session_id() ?>">Reinstate</a>
							<?php } else { ?>
								<a href="admin/index/community/person/7/?revoke=<?php echo $suspend->getId() ?>&authorize=<?php echo session_id() ?>">Revoke</a>
							<?php } ?>
						</td>
					</tr>
					<?php } ?>
				</table>
			</div>
			<?php } ?>
		</div>
		<?php } ?>
		<div class="admin-person-main-item">
			<div class="admin-person-main-item-inner">
				<h2>Statistics</h2>
			</div>
		</div>
		<div class="admin-person-main-item">
			<div class="admin-person-main-item-inner">
				<h2>Contact this Person</h2>
			</div>
		</div>
	</div>
</div>
