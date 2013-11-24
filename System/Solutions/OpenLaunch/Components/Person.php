
<div class="admin-person-wrap">
    <div class="admin-person-header">
        <div class="admin-person-header-inner">
            <div class="admin-person-header-avatar">
				<?php echo $person->getAvatar(188) ?>
            </div>
            <div class="admin-person-header-text">
                <h1><?php echo $person->getName() ?> <a href='/admin/index/community/'>back</a></h1>
            </div>
            <div class="admin-person-header-options">
                <a href=""><div class="admin-person-header-option admin-person-header-option-dashboard">
                        <div class="admin-person-header-option-inner">Dashboard</div>
					</div></a><a href=""><div class="admin-person-header-option admin-person-header-option-suspend">
                        <div class="admin-person-header-option-inner">Suspend</div>
					</div></a><a href=""><div class="admin-person-header-option admin-person-header-option-ban">
                        <div class="admin-person-header-option-inner">Ban Person</div>
					</div></a><a href=""><div class="admin-person-header-option admin-person-header-option-profile">
                        <div class="admin-person-header-option-inner">Profile</div>
					</div></a><a href=""><div class="admin-person-header-option admin-person-header-option-statistics">
                        <div class="admin-person-header-option-inner">Statistics</div>
					</div></a><a href=""><div class="admin-person-header-option admin-person-header-option-contact">
                        <div class="admin-person-header-option-inner">Contact</div>
					</div></a>
            </div>
        </div>
    </div>
	<div class="admin-person-main">
		<div class="admin-person-main-item">
			<div class="admin-person-main-item-inner">
				<div class="admin-person-main-item-right"><a href="">Remove Profile</a></div>
				<h2>Public Profile</h2>
				<div class="admin-person-main-text">
					<?php echo $person->getProfile() ?>
				</div>
			</div>
		</div>
		<div class="admin-person-main-item">
			<div class="admin-person-main-item-inner">
				<div class="admin-person-main-item-right"><a href="">Edit Details</a></div>
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
		<div class="admin-person-main-item">
			<div class="admin-person-main-item-inner">
				<h2>Assigned Roles</h2>
				<?php
				foreach ($roles as $role) {
					$assigned = in_array($role, $person->getRoles())
					?><div class="admin-entry-column-smaller <?php echo ($assigned) ? "assigned" : "unassigned" ?>">
						<div class="admin-entry-column-smaller-inner">
							<?php echo $role->getIcon() ?>
							<h2><?php echo $role->get("name") ?></h2>
							<?php if ($assigned) { ?>
								<a href="?unrole=<?php echo $role->getId() ?>&sid=<?php echo session_id() ?>" onclick="return confirm('Remove this person from the <?php echo $role->get("name") ?> role?')">Assigned to this Role</a>
							<?php } else { ?>
								<a href="?role=<?php echo $role->getId() ?>&sid=<?php echo session_id() ?>" onclick="return confirm('Assign this person to the <?php echo $role->get("name") ?> role?')">Not assigned to this Role</a>
							<?php } ?>
						</div>
					</div><?php } ?>
			</div>
		</div>
		<div class="admin-person-main-item">
			<div class="admin-person-main-item-inner">
				<h2>Moderator Tools</h2>
			</div>
		</div>
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
