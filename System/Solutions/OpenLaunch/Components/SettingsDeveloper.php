<div class="admin-person-main-item">
    <div class="admin-person-main-item-inner">
        <h2>Cache Options</h2>
        <div class="admin-entry-column-smaller"><a href="?recache=<?php echo session_id() ?>">
                <div class="admin-entry-column-smaller-inner">
                    <img src="/Images/Flat/IconFinder/Refresh.png" />
                    <h2>Clear Cache</h2>
                    Reset the stylesheet
                </div>
            </a></div><?php if (Settings::get("website.nocache") == "true") { ?><div class="admin-entry-column-smaller"><a href="?cache=<?php echo session_id() ?>">
                <div class="admin-entry-column-smaller-inner">
                    <img src="/Images/Flat/IconFinder/Pause.png" />
                    <h2>Caching Disabled</h2>
                    Click here to enable
                </div>
            </a></div><?php } else { ?><div class="admin-entry-column-smaller"><a href="?nocache=<?php echo session_id() ?>">
				<div class="admin-entry-column-smaller-inner">
					<img src="/Images/Flat/IconFinder/Play.png" />
					<h2>Caching Enabled</h2>
					Click here to disable
				</div>
            </a></div><?php } ?>
    </div>
</div>