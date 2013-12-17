<div class="admin-entry">
	<div class="admin-entry-inner">
		<label>Private Key:</label>
		<input type="text" value="<?php echo Security::getPrivateKey() ?>" size="100" />
	</div>
</div>
<div class="admin-entry">
	<div class="admin-entry-inner">
		In an OpenLaunch Cluster, one server controls multiple other
		OpenLaunch servers. Whenever the controlling server, or
		"parent," adds a role, or assigns someone to a roll, the
		servers which are being controlled, or the "children," will
		be updated with these changes. This allows a company or
		similar organization to easily maintain multiple websites
		which have the same administrators and settings. To add a
		server to this server's cluster, copy the private key from
		that server's "Cluster" page, and paste it in below.
	</div>
</div>
<div class="admin-entry">
	<div class="admin-entry-inner">
		This feature is coming soon.
	</div>
</div>